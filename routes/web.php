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

Route::post('/send-message', [WhatsAppController::class,'send']);

Route::get('/webhook', [WhatsAppController::class,'verify']);

Route::post('/webhook', [WhatsAppController::class,'receive']);