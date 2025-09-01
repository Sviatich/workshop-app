<?php

namespace App\Http\Controllers;

use App\Services\CdekService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class CdekController extends Controller
{
    public function cities(Request $request, CdekService $svc)
    {
        $q = trim((string) $request->query('query', ''));
        if ($q === '') {
            return response()->json([]);
        }
        return response()->json($svc->listCities($q));
    }

    public function offices(Request $request, CdekService $svc)
    {
        $validator = Validator::make($request->all(), [
            'city_code' => 'required|integer|min:1',
            'type' => 'nullable|in:PVZ,POSTAMAT,ALL',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid params', 'errors' => $validator->errors()], 422);
        }
        $cityCode = (int) $request->input('city_code');
        $type = $request->has('type') ? (string) $request->input('type') : null;
        if ($type === 'ALL') $type = null;
        return response()->json($svc->listOffices($cityCode, $type));
    }

    public function calculateOffice(Request $request, CdekService $svc)
    {
        $validator = Validator::make($request->all(), [
            'to_code' => 'required|integer|min:1',
            'packages' => 'required|array|min:1',
            'packages.*.length' => 'required|integer|min:1',
            'packages.*.width' => 'required|integer|min:1',
            'packages.*.height' => 'required|integer|min:1',
            'packages.*.weight' => 'required|integer|min:1',
            'office_code' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid params', 'errors' => $validator->errors()], 422);
        }

        $payload = [
            'from_location' => ['code' => null], // set in service
            'to_location' => ['code' => (int) $request->input('to_code')],
            'packages' => array_values($request->input('packages')),
        ];

        $tariffs = $svc->calculateTariffs($payload, 'office');
        return response()->json([
            'tariffs' => $tariffs,
            'best' => $tariffs[0] ?? null,
        ]);
    }

    public function calculateDoor(Request $request, CdekService $svc)
    {
        $validator = Validator::make($request->all(), [
            'to_address' => 'required|string|min:4',
            'postal_code' => 'nullable|string|min:4|max:10',
            'country_code' => 'nullable|string|size:2',
            'packages' => 'required|array|min:1',
            'packages.*.length' => 'required|integer|min:1',
            'packages.*.width' => 'required|integer|min:1',
            'packages.*.height' => 'required|integer|min:1',
            'packages.*.weight' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid params', 'errors' => $validator->errors()], 422);
        }

        $to = [
            'address' => (string) $request->input('to_address'),
        ];
        if ($pc = $request->input('postal_code')) {
            $to['postal_code'] = (string) $pc;
        }
        if ($cc = $request->input('country_code')) {
            $to['country_code'] = (string) $cc;
        }

        $payload = [
            'from_location' => ['code' => null], // set in service
            'to_location' => $to,
            'packages' => array_values($request->input('packages')),
        ];

        $tariffs = $svc->calculateTariffs($payload, 'door');
        return response()->json([
            'tariffs' => $tariffs,
            'best' => $tariffs[0] ?? null,
        ]);
    }
}
