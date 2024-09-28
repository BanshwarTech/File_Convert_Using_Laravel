<?php

use App\Http\Controllers\FilesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FilesController::class, 'index'])->name('index');

Route::get('/generate-pdf', [FilesController::class, 'generatePdf'])->name('generate-pdf');

// Search route
Route::get('/search', [FilesController::class, 'search'])->name('search');
// export csv file
Route::get('/export-csv', [FilesController::class, 'exportCsv'])->name('export-csv');
// export docx file
Route::get('/export-docx', [FilesController::class, 'exportDocx'])->name('export-docx');
// export excel file
Route::get('/export-excel', [FilesController::class, 'exportExcel'])->name('export-excel');
// export json file
Route::get('/export-json', [FilesController::class, 'exportJson'])->name('export-json');
// export xml file
Route::get('/export-xml', [FilesController::class, 'exportXml'])->name('export-xml');
// About page route
Route::get('/about-us', [FilesController::class, 'aboutUs'])->name('about-us');