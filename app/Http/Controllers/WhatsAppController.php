<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    public function verify(Request $request)
    {
        $verify_token = "1400_BPSRiauH3b4t";

        $mode = $request->query('hub.mode') ?? $request->query('hub_mode');
        $token = $request->query('hub.verify_token') ?? $request->query('hub_verify_token');
        $challenge = $request->query('hub.challenge') ?? $request->query('hub_challenge');

        if ($mode == "subscribe" && $token == $verify_token) {
            return response($challenge, 200);
        }

        return response("Forbidden",403);
    }

    public function receive(Request $request)
    {
        Log::info('META RECEIVE LOCAL');
        Log::info($request->all());

        try {

            Http::timeout(30)
                ->acceptJson()
                ->post(
                    'https://riau.web.bps.go.id/asampedas/webhook',
                    $request->all()
                );

        } catch (\Exception $e) {

            Log::error($e->getMessage());

        }

        return response()->json([
            'success'=>true
        ]);
    }
}