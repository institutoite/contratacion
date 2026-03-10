<?php

use App\Http\Controllers\ApplicantController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/applicants');

Route::resource('applicants', ApplicantController::class);
Route::patch('/applicants/{applicant}/quick-update', [ApplicantController::class, 'quickUpdate'])->name('applicants.quick-update');
Route::post('/applicants/{applicant}/interviews', [ApplicantController::class, 'storeInterview'])->name('applicants.interviews.store');
Route::get('/applicants-export', [ApplicantController::class, 'export'])->name('applicants.export');

Route::get('/attachments/{attachment}/download', [ApplicantController::class, 'downloadAttachment'])->name('attachments.download');
Route::delete('/attachments/{attachment}', [ApplicantController::class, 'destroyAttachment'])->name('attachments.destroy');

Route::patch('/positions/{position}/toggle', [ApplicantController::class, 'togglePosition'])->name('positions.toggle');
