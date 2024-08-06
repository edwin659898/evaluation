<?php

use App\Http\Livewire\DropDown;
use App\Http\Livewire\FollowUp;
use App\Http\Livewire\SecFive;
use App\Http\Livewire\SectionThree;
use App\Http\Livewire\Users;
use Illuminate\Support\Facades\Route;
use Knp\Snappy\Pdf;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//User
Route::post('/my-evaluation-report', [\App\Http\Controllers\ExtraInformationController::class, 'file'])->name('file.view');
Route::get('/view-pdf/{slug}', [\App\Http\Controllers\ExtraInformationController::class, 'viewMyPDF'])->name('myEvaluation.PDF');
Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('/Extra-Information', [\App\Http\Controllers\ExtraInformationController::class, 'moreInfo'])->name('more.information');
    Route::post('/store-Performance-Evaluation', [\App\Http\Controllers\ExtraInformationController::class, 'store'])->name('store.evaluation');
    Route::get('/Section-one', [\App\Http\Controllers\SectionOneController::class, 'create'])->name('section.one');
    Route::post('/Section-one', [\App\Http\Controllers\SectionOneController::class, 'store'])->name('sectionOne.store');
    Route::get('/Section-two', [\App\Http\Controllers\SectionTwoController::class, 'create'])->name('section.two');
    Route::post('/Section-two', [\App\Http\Controllers\SectionTwoController::class, 'store'])->name('sectionTwo.store');
    Route::post('/Signature', [\App\Http\Controllers\SignatureController::class, 'store'])->name('signature.store');
    Route::get('/Section-three', SectionThree::class)->name('section.three');
    Route::get('/Section-four', [\App\Http\Controllers\SectionFourController::class, 'create'])->name('section.four');
    Route::post('/Section-four', [\App\Http\Controllers\SectionFourController::class, 'store'])->name('sectionFour.store');
    Route::get('/Section-five', SecFive::class)->middleware('PreventAccess')->name('section.five');
    Route::get('/Section-six', [\App\Http\Controllers\SectionSixController::class, 'create'])->name('section.six');
    Route::post('/Section-six', [\App\Http\Controllers\SectionSixController::class, 'store'])->name('sectionSix.store');
    Route::get('/preview', [\App\Http\Controllers\SectionSixController::class, 'final'])->name('final');
    Route::get('/print-my-results', [\App\Http\Controllers\SectionSixController::class, 'printResults'])->name('final.results');
    Route::get('New-Performance-Evaluation', [\App\Http\Controllers\ExtraInformationController::class, 'index'])->middleware('auth')->name('new.evaluation');
    Route::get('/dashboard', [\App\Http\Controllers\ExtraInformationController::class, 'dashboard'])->middleware('auth')->name('dashboard');
    Route::get('/previous-evaluation/{id}', [\App\Http\Controllers\ExtraInformationController::class, 'previousEvaluation'])->name('prev.eval');
});

//Manager
Route::prefix('manager')->middleware(['auth'])->group(function () {
    Route::get('/Information-technology', [\App\Http\Controllers\SupervisorController::class, 'IT'])->name('manager.it');
    Route::get('/Monitoring-evalution', [\App\Http\Controllers\SupervisorController::class, 'ME'])->name('manager.me');
    Route::get('/Communications', [\App\Http\Controllers\SupervisorController::class, 'Communications'])->name('manager.Communications');
    Route::get('/Accounts', [\App\Http\Controllers\SupervisorController::class, 'Accounts'])->name('manager.Accounts');
    Route::get('/Operations', [\App\Http\Controllers\SupervisorController::class, 'Operations'])->name('manager.Operations');
    Route::get('/Human-Resources', [\App\Http\Controllers\SupervisorController::class, 'HR'])->name('manager.HR');
    Route::get('/Forestry', [\App\Http\Controllers\SupervisorController::class, 'Forestry'])->name('manager.Forestry');
    Route::get('/Miti-magazine', [\App\Http\Controllers\SupervisorController::class, 'MITI'])->name('manager.MITI');
    Route::get('/view-{id}', [\App\Http\Controllers\SupervisorController::class, 'view'])->name('manager.view');
    Route::patch('/view-{id}', [\App\Http\Controllers\SupervisorController::class, 'comment'])->name('manager.comment');
});

//HOD
Route::prefix('HOD')->middleware(['auth'])->group(function () {
    Route::get('/Information-technology', [\App\Http\Controllers\HODController::class, 'IT'])->name('hod.it');
    Route::get('/Monitoring-evalution', [\App\Http\Controllers\HODController::class, 'ME'])->name('hod.me');
    Route::get('/Communications', [\App\Http\Controllers\HODController::class, 'Communications'])->name('hod.Communications');
    Route::get('/Accounts', [\App\Http\Controllers\HODController::class, 'Accounts'])->name('hod.Accounts');
    Route::get('/Operations', [\App\Http\Controllers\HODController::class, 'Operations'])->name('hod.Operations');
    Route::get('/Human-Resources', [\App\Http\Controllers\HODController::class, 'HR'])->name('hod.HR');
    Route::get('/Forestry', [\App\Http\Controllers\HODController::class, 'Forestry'])->name('hod.Forestry');
    Route::get('/Miti-magazine', [\App\Http\Controllers\HODController::class, 'MITI'])->name('hod.MITI');
    Route::get('/view-{id}', [\App\Http\Controllers\HODController::class, 'view'])->name('hod.view');
    Route::patch('/view-{id}', [\App\Http\Controllers\HODController::class, 'comment'])->name('hod.comment');
});

//follow up
Route::middleware(['auth'])->group(function () {
    Route::get('/Follow-up', [\App\Http\Controllers\HODController::class, 'followUp'])->name('follow.up');
    Route::get('/follow-up/{id}/view', [\App\Http\Controllers\HODController::class, 'report'])->name('followup.view');
    Route::get('/filing/{id}', [\App\Http\Controllers\HODController::class, 'filing'])->name('filing');
    Route::get('/Excel', [\App\Http\Controllers\ExtraInformationController::class, 'excel'])->name('excel.expo');
    Route::get('/Add-dropdown', DropDown::class)->name('add.dropdown');
    Route::get('/users', Users::class)->name('manage.users');
});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/test', function () {
    $pdf = app(Pdf::class);

    $pdf->setBinary('/usr/local/bin/wkhtmltopdf'); 

    $html = view('hod.spdf')->render();

    $options = [
        'page-size' => 'A4',
        'margin-top' => 10, 
        'margin-right' => 10,
        'margin-bottom' => 10,
        'margin-left' => 10,
        //'no-images' => true,  
        //'no-background' => true, 
    ];

    $output = public_path('example.pdf');
    $cssSelector = '.evaluation';

    $pdf->generateFromHtml($html, $output, $options, true, [
        '--viewport-size' => $cssSelector, 
    ]);
});

require __DIR__ . '/auth.php';
