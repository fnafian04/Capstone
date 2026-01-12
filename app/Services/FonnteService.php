<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    public function send($phones, $message)
    {
        $targets = is_array($phones) ? $phones : [$phones];

        $response = Http::withHeaders([
            'Authorization' => config('services.fonnte.token'),
        ])->post('https://api.fonnte.com/send', [
            'target' => implode(',', $targets), // ⬅ FIX PENTING
            'message' => $message,
            'countryCode' => '62',
        ]);

        Log::info('🔥 KIRIM WA KE: ' . implode(',', $targets));
        Log::info('📩 RESPON FONNTE: ' . json_encode($response->json()));

        return $response->json();
    }
}
