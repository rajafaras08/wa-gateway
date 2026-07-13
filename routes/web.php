<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhatsAppController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/send-message', [WhatsAppController::class,'sendMessage']);

Route::get('/webhook', [WhatsAppController::class,'verify']);

Route::post('/webhook', [WhatsAppController::class,'receive']);