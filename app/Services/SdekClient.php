<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SdekClient
{
    protected string $baseUrl;
    protected string $clientId;
    protected string $clientSecret;
    protected int $senderCode;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.sdek.base_url', env('CDEK_BASE_URL', 'https://api.cdek.ru/v2')), '/');
        $this->clientId = (string) config('services.sdek.client_id', env('CDEK_CLIENT_ID'));
        $this->clientSecret = (string) config('services.sdek.client_secret', env('CDEK_CLIENT_SECRET'));
        $this->senderCode = (int) config('services.sdek.sender_code', env('CDEK_SENDER_CODE', 171));
    }

    public function senderCode(): int
    {
        return $this->senderCode;
    }

    public function token(): string
    {
        return Cache::remember('sdek_api_token', 50 * 60, function () {
            $resp = Http::asForm()
                ->acceptJson()
                ->post($this->baseUrl . '/oauth/token', [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ]);

            if (!$resp->ok() || !isset($resp['access_token'])) {
                abort(502, 'SDEK auth failed');
            }
            return (string) $resp['access_token'];
        });
    }

    protected function http()
    {
        return Http::withToken($this->token())
            ->acceptJson()
            ->withHeaders([
                'X-App-Name' => 'custom_integration',
                'X-App-Version' => '1.0.0',
            ]);
    }

    public function cities(string $query, int $size = 10): array
    {
        // Try both possible param names used by API over time
        $resp = $this->http()->get($this->baseUrl . '/location/cities', [
            'country_codes' => 'RU',
            'city' => $query,
            'size' => $size,
            'lang' => 'rus',
        ]);

        if ($resp->status() === 400) {
            $resp = $this->http()->get($this->baseUrl . '/location/cities', [
                'country_codes' => 'RU',
                'q' => $query,
                'size' => $size,
            ]);
        }

        if (!$resp->ok()) {
            abort(502, 'SDEK cities error');
        }
        return $resp->json();
    }

    public function deliveryPoints(array $params): array
    {
        $resp = $this->http()->get($this->baseUrl . '/deliverypoints', $params);
        if (!$resp->ok()) {
            abort(502, 'SDEK deliverypoints error');
        }
        return $resp->json();
    }

    public function tariffList(array $payload): array
    {
        $resp = $this->http()->post($this->baseUrl . '/calculator/tarifflist', $payload);
        if (!$resp->ok()) {
            abort($resp->status(), (string) $resp->body());
        }
        return $resp->json();
    }

    public function tariff(array $payload): array
    {
        $resp = $this->http()->post($this->baseUrl . '/calculator/tariff', $payload);
        if (!$resp->ok()) {
            abort($resp->status(), (string) $resp->body());
        }
        return $resp->json();
    }
}
