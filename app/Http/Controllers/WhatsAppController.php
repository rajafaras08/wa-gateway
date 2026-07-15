<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    public function verify(Request $request)
    {
        $verify_token = config('whatsapp.verify_token');

        $mode = $request->query('hub.mode') ?? $request->query('hub_mode');
        $token = $request->query('hub.verify_token') ?? $request->query('hub_verify_token');
        $challenge = $request->query('hub.challenge') ?? $request->query('hub_challenge');

        if ($mode == "subscribe" && $token == $verify_token) {
            return response($challenge, 200);
        }

        return response("Forbidden",403);
    }

    // public function receive(Request $request)
    // {
    //     try {

    //         Log::info('=== META RECEIVE ===');
    //         Log::info($request->all());

    //         $response = Http::timeout(30)
    //             ->acceptJson()
    //             ->post(
    //                 'https://riau.web.bps.go.id/asampedas/webhook',
    //                 $request->all()
    //             );

    //         return response()->json([
    //             'success' => true,
    //             'status' => $response->status(),
    //             'body' => $response->body(),
    //         ]);

    //     } catch (\Throwable $e) {

    //         return response()->json([
    //             'success' => false,
    //             'message' => $e->getMessage(),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //         ],500);

    //     }
    // }

    public function receive(Request $request)
    {
        return response()->json([
            'success' => true
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'nomor' => 'required',
            'pesan' => 'required',
        ]);

        $response = Http::withToken(config('whatsapp.token'))
            ->post(
                "https://graph.facebook.com/"
                . config('whatsapp.graph_version')
                . "/"
                . config('whatsapp.phone_number_id')
                . "/messages",
                [
                    "messaging_product" => "whatsapp",
                    "to" => $request->nomor,
                    "type" => "text",
                    "text" => [
                        "body" => $request->pesan
                    ]
                ]
            );

        Log::info('SEND TO META');
        Log::info($response->json());

        return response()->json($response->json(), $response->status());
    }
}