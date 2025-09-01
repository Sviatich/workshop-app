<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class CdekService
{
    private string $baseUrl;
    private string $clientId;
    private string $clientSecret;
    private int $fromCode;
    private array $allowedOffice;
    private array $allowedDoor;

    public function __construct()
    {
        $cfg = Config::get('services.cdek');
        $this->baseUrl = (string) ($cfg['base_url'] ?? 'https://api.cdek.ru/v2');
        $this->clientId = (string) ($cfg['client_id'] ?? '');
        $this->clientSecret = (string) ($cfg['client_secret'] ?? '');
        $this->fromCode = (int) ($cfg['from_code'] ?? 171);
        $this->allowedOffice = $this->parseCodes((string) ($cfg['allowed_tariffs_office'] ?? '138'));
        $this->allowedDoor = $this->parseCodes((string) ($cfg['allowed_tariffs_door'] ?? '139'));
    }

    private function parseCodes(string $csv): array
    {
        return array_values(array_filter(array_map(static function ($v) {
            return (int) trim((string) $v);
        }, explode(',', $csv)), static function ($v) {
            return $v > 0;
        }));
    }

    public function getToken(): string
    {
        $cacheKey = 'cdek:oauth:token';
        $cached = Cache::get($cacheKey);
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        $resp = Http::asForm()
            ->baseUrl($this->baseUrl)
            ->withUserAgent('workshop-app/1.0')
            ->acceptJson()
            ->post('oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

        $resp->throw();
        $data = $resp->json();
        $token = (string) Arr::get($data, 'access_token', '');
        $ttl = (int) Arr::get($data, 'expires_in', 3600);
        if ($token === '') {
            throw new \RuntimeException('CDEK auth failed: empty token');
        }
        // Store slightly less than expires_in to be safe
        Cache::put($cacheKey, $token, now()->addSeconds(max(300, $ttl - 60)));
        return $token;
    }

    private function client()
    {
        return Http::baseUrl($this->baseUrl)
            ->withUserAgent('workshop-app/1.0')
            ->acceptJson()
            ->withHeaders([
                'X-App-Name' => 'workshop_app',
                'X-App-Version' => '1.0',
            ])
            ->withToken($this->getToken());
    }

    public function listCities(string $query, string $country = 'RU'): array
    {
        $resp = $this->client()->get('location/cities', [
            'country_codes' => $country,
            'city' => $query,
            // limit results for UI
            'size' => 20,
            'page' => 0,
        ]);
        $resp->throw();
        $items = $resp->json();
        if (!is_array($items)) return [];
        return array_map(static function ($i) {
            return [
                'code' => (int) ($i['code'] ?? 0),
                'city' => (string) ($i['city'] ?? ''),
                'full_name' => trim(
                    implode(', ', array_filter([
                        $i['city'] ?? null,
                        $i['region'] ?? null,
                        $i['country_name'] ?? null,
                    ]))
                ),
            ];
        }, $items);
    }

    public function listOffices(int $cityCode, ?string $type = 'PVZ'): array
    {
        $mapFn = static function ($arr) {
            return array_values(array_map(static function ($i) {
                return [
                    'code' => (string) ($i['code'] ?? ''),
                    'name' => (string) ($i['name'] ?? ''),
                    'address' => (string) ($i['location']['address'] ?? ''),
                    'postal_code' => (string) ($i['location']['postal_code'] ?? ''),
                    'lat' => isset($i['location']['latitude']) ? (float) $i['location']['latitude'] : null,
                    'lon' => isset($i['location']['longitude']) ? (float) $i['location']['longitude'] : null,
                    'work_time' => (string) ($i['work_time'] ?? ''),
                ];
            }, $arr));
        };

        $params = [
            'city_code' => $cityCode,
            'is_handout' => 1,
            'is_dressing_room' => 0,
        ];

        $all = [];
        if ($type === null) {
            // Try without type (should include PVZ + POSTOMAT)
            $resp = $this->client()->get('deliverypoints', $params);
            $resp->throw();
            $items = $resp->json();
            if (is_array($items)) { $all = array_merge($all, $items); }
            // As a safety, also request explicitly PVZ and POSTOMAT and merge (dedupe by code)
            foreach (['PVZ', 'POSTAMAT'] as $t) {
                $r = $this->client()->get('deliverypoints', $params + ['type' => $t]);
                $r->throw();
                $its = $r->json();
                if (is_array($its)) { $all = array_merge($all, $its); }
            }
            // Deduplicate by code
            $seen = [];
            $all = array_values(array_filter($all, static function ($i) use (&$seen) {
                $code = (string) ($i['code'] ?? '');
                if ($code === '' || isset($seen[$code])) return false;
                $seen[$code] = true; return true;
            }));
            return $mapFn($all);
        }

        // Single type
        $resp = $this->client()->get('deliverypoints', $params + ['type' => $type]);
        $resp->throw();
        $items = $resp->json();
        if (!is_array($items)) return [];
        return $mapFn($items);
    }

    public function calculateTariffs(array $payload, string $mode): array
    {
        // Ensure from_location/from_code and packages are present
        $payload['from_location'] = $payload['from_location'] ?? ['code' => $this->fromCode];
        if (!isset($payload['from_location']['code'])) {
            $payload['from_location']['code'] = $this->fromCode;
        }

        $resp = $this->client()
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('calculator/tarifflist', $payload);

        $resp->throw();
        $data = $resp->json();
        if (!is_array($data)) return [];

        $allowed = $mode === 'office' ? $this->allowedOffice : $this->allowedDoor;
        $tariffs = array_values(array_filter((array) ($data['tariff_codes'] ?? []), static function ($t) use ($allowed) {
            $code = (int) ($t['tariff_code'] ?? 0);
            return $code > 0 && (empty($allowed) || in_array($code, $allowed, true));
        }));

        usort($tariffs, static function ($a, $b) {
            $aa = (float) ($a['delivery_sum'] ?? 0);
            $bb = (float) ($b['delivery_sum'] ?? 0);
            return $aa <=> $bb;
        });

        return $tariffs;
    }
}
