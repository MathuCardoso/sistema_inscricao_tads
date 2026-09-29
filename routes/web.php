<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class);

    //INSCRIÇÃO ONLY
    Route::get('/inscricao', [InscricaoController::class, 'create']);
    Route::post('/inscricao', [InscricaoController::class, 'store']);

    Route::post('/participantes', [ParticipantController::class, 'store'])
        ->name('participant.post');

    Route::put('/participantes/{participant}', [ParticipantController::class, 'update']);

    Route::patch('/registrations/{registration}/presence', [RegistrationController::class, 'togglePresence']);
});

// LOGIN
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
