<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test', function () {
    return 'OK';
});

Route::get('/debug', function () {
    throw new Exception('TEST');
});

Route::get('/cek-asampedas', function () {

    $response = Http::timeout(30)
        ->get('https://riau.web.bps.go.id/asampedas');

    return [
        'status' => $response->status(),
        'body' => $response->body(),
    ];
});

Route::post('/send-message', [WhatsAppController::class,'send']);

Route::get('/webhook', [WhatsAppController::class,'verify']);

Route::post('/webhook', [WhatsAppController::class,'receive']);