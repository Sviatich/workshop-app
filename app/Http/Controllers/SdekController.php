<?php

namespace App\Http\Controllers;

use App\Services\SdekClient;
use Illuminate\Http\Request;

class SdekController extends Controller
{
    public function __construct(private readonly SdekClient $sdek)
    {
    }

    public function cities(Request $request)
    {
        $q = (string) $request->query('q', '');
        if (mb_strlen($q) < 2) {
            return response()->json([]);
        }
        $list = $this->sdek->cities($q, 10);
        // Normalize output
        $norm = array_map(function ($it) {
            return [
                'code' => $it['code'] ?? null,
                'city' => $it['city'] ?? ($it['name'] ?? ''),
                'region' => $it['region'] ?? ($it['region_code'] ?? ''),
                'country_code' => $it['country_code'] ?? 'RU',
                'longitude' => $it['longitude'] ?? null,
                'latitude' => $it['latitude'] ?? null,
            ];
        }, $list ?? []);

        return response()->json($norm);
    }

    public function pvz(Request $request)
    {
        $code = (int) $request->query('city_code');
        if ($code <= 0) {
            return response()->json(['message' => 'city_code is required'], 422);
        }

        $points = $this->sdek->deliveryPoints([
            'city_code' => $code,
            'country_code' => 'RU',
            'type' => 'PVZ',
            'is_handout' => true,
            'lang' => 'rus',
        ]);

        $items = array_values(array_map(function ($p) {
            return [
                'code' => $p['code'] ?? null,
                'name' => $p['name'] ?? '',
                'address' => $p['location']['address'] ?? '',
                'longitude' => $p['location']['longitude'] ?? null,
                'latitude' => $p['location']['latitude'] ?? null,
                'work_time' => $p['work_time'] ?? '',
                'phones' => $p['phones'] ?? [],
            ];
        }, $points ?? []));

        return response()->json($items);
    }

    public function calcCourier(Request $request)
    {
        $data = $request->validate([
            'address' => 'required|string|min:5',
            'fias_guid' => 'nullable|string',
            'packages' => 'required|array|min:1',
            'packages.*.weight' => 'required|integer|min:1',
            'packages.*.length' => 'required|integer|min:1',
            'packages.*.width' => 'required|integer|min:1',
            'packages.*.height' => 'required|integer|min:1',
        ]);

        $codes = array_values(array_filter(array_map('intval', explode(',', (string) config('services.sdek.allowed_tariffs_door', '139')))));
        if (empty($codes)) { $codes = [139]; }

        $toLocation = [ 'address' => $data['address'] ];
        if (!empty($data['fias_guid'])) {
            $toLocation['fias_guid'] = $data['fias_guid'];
        }

        $payload = [
            'type' => 1,
            // currency omitted: API defaults to RUB; avoids type mismatch
            'tariff_codes' => $codes,
            'from_location' => [ 'code' => $this->sdek->senderCode() ],
            'to_location' => $toLocation,
            'packages' => $data['packages'],
        ];

        $res = $this->sdek->tariffList($payload);
        $item = $res['tariff_codes'][0] ?? null;

        return response()->json([
            'tariff' => $item,
        ]);
    }

    public function calcPvz(Request $request)
    {
        $data = $request->validate([
            'city_code' => 'required|integer|min:1',
            'pvz_code' => 'nullable|string',
            'packages' => 'required|array|min:1',
            'packages.*.weight' => 'required|integer|min:1',
            'packages.*.length' => 'required|integer|min:1',
            'packages.*.width' => 'required|integer|min:1',
            'packages.*.height' => 'required|integer|min:1',
        ]);

        $codes = array_values(array_filter(array_map('intval', explode(',', (string) config('services.sdek.allowed_tariffs_office', '138')))));
        if (empty($codes)) { $codes = [138]; }

        // If PVZ code provided, use precise single-tariff calculation
        if (!empty($data['pvz_code'])) {
            // 1) Request available tariffs for this city
            $listPayload = [
                'type' => 1,
                'tariff_codes' => $codes,
                'from_location' => [ 'code' => $this->sdek->senderCode() ],
                'to_location' => [ 'code' => $data['city_code'] ],
                'packages' => $data['packages'],
            ];
            $list = $this->sdek->tariffList($listPayload);
            $best = $list['tariff_codes'][0] ?? null;
            if (!$best) {
                return response()->json(['message' => 'Нет доступных тарифов для выбранного города/ПВЗ'], 422);
            }
            // 2) Request exact tariff for chosen PVZ
            $payload = [
                'type' => 1,
                'tariff_code' => (int) ($best['tariff_code'] ?? $codes[0]),
                'from_location' => [ 'code' => $this->sdek->senderCode() ],
                'to_location' => [ 'code' => $data['city_code'] ],
                'delivery_point' => $data['pvz_code'],
                'packages' => $data['packages'],
            ];
            try {
                $res = $this->sdek->tariff($payload);
                return response()->json(['tariff' => $res]);
            } catch (\Throwable $e) {
                // Fallback to the best tarifflist item if precise request failed
                $fallback = $this->sdek->tariffList($listPayload);
                $best = $fallback['tariff_codes'][0] ?? null;
                if ($best) return response()->json(['tariff' => $best]);
                return response()->json(['message' => 'Не удалось рассчитать доставку до ПВЗ'], 422);
            }
        }

        $payload = [
            'type' => 1,
            'tariff_codes' => $codes,
            'from_location' => [ 'code' => $this->sdek->senderCode() ],
            'to_location' => [ 'code' => $data['city_code'] ],
            'packages' => $data['packages'],
        ];
        $res = $this->sdek->tariffList($payload);
        $item = $res['tariff_codes'][0] ?? null;
        return response()->json(['tariff' => $item]);
    }
}
