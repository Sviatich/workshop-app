<?php

namespace App\Http\Responders;

use Closure;
use Illuminate\Http\Request;
use Spatie\Honeypot\SpamResponder\SpamResponder;

class HoneypotJsonResponder implements SpamResponder
{
    public function respond(Request $request, Closure $next)
    {
        $payload = [
            'message' => 'Проверка на спам не пройдена',
        ];

        // If the client expects HTML, fall back to a minimal response
        if (! str_contains(strtolower($request->header('accept', '')), 'application/json')) {
            return response()->json($payload, 422);
        }

        return response()->json($payload, 422);
    }
}

