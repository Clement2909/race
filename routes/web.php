<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\TeamAuthController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\RunnerController;
use App\Http\Controllers\CategoryGenerationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImportPointController;
use App\Http\Controllers\ImportTwoCsvController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\CertificateController;


//ACCEUIL PRINCIPAL OU INDEX
Route::get('/', [TeamAuthController::class, 'showLoginForm']);


//ADMIN
// Afficher le formulaire de connexion pour l'administrateur
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

// Gérer la soumission du formulaire de connexion pour l'administrateur
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Afficher le tableau de bord de l'administrateur
Route::get('/admin/dashboard', [AdminAuthController::class, 'showDashboard'])->name('admin.dashboard');

// Déconnecter l'administrateur
Route::get('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');



//USER
// Afficher le formulaire de connexion pour l'utilisateur
Route::get('team/login', [TeamAuthController::class, 'showLoginForm'])->name('team.login');

// Gérer la soumission du formulaire de connexion pour l'utilisateur
Route::post('team/login', [TeamAuthController::class, 'login'])->name('team.login.submit');

// Afficher le tableau de bord de l'utilisateur
Route::get('/team/dashboard', [TeamAuthController::class, 'showDashboard'])->name('team.dashboard');

// Déconnecter l'administrateur
Route::get('team/logout', [TeamAuthController::class, 'logout'])->name('team.logout');


// afficher le etapes
Route::get('/steps', [StepController::class, 'index'])->name('steps.index');
Route::get('/steps1', [StepController::class, 'index1'])->name('steps.indexteam');

// afficher classement
//admin
Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
Route::get('/teamRank', [RankingController::class, 'teamRank'])->name('teamRank');
Route::get('/rankMale', [RankingController::class, 'teamRankMale'])->name('rankMale');
Route::get('/rankFemale', [RankingController::class, 'teamRankFemale'])->name('rankFemale');
Route::get('/rankJunior', [RankingController::class, 'teamRankJunior'])->name('rankJunior');
Route::get('/rankSenior', [RankingController::class, 'teamRankSenior'])->name('rankSenior');


// team
Route::get('/rankingt', [RankingController::class, 'indext'])->name('ranking.indext');
Route::get('/teamRankt', [RankingController::class, 'teamRankt'])->name('teamRankt');
Route::get('/rankMalet', [RankingController::class, 'teamRankMalet'])->name('rankMalet');
Route::get('/rankFemalet', [RankingController::class, 'teamRankFemalet'])->name('rankFemalet');
Route::get('/rankJuniort', [RankingController::class, 'teamRankJuniort'])->name('rankJuniort');
Route::get('/rankSeniotr', [RankingController::class, 'teamRankSeniort'])->name('rankSeniort');




Route::get('/select-runners/{step_id}/{remaining_runners}', [RunnerController::class, 'selectRunners'])->name('selectRunners');

Route::post('/selectRunners/{step_id}/{rest}', [RunnerController::class, 'storeSelectedRunners'])->name('storeSelectedRunners');

Route::put('/ranking/{step}', [RankingController::class, 'update'])->name('ranking.update');


Route::get('/assign-categories', [CategoryGenerationController::class, 'assignCategoriesAutomatically'])->name('assignCategoriesAutomatically');



////////////////////////////   EFFACER BASE  //////////////////
Route::get('/admin/clear-data', [AdminController::class, 'clearData'])->name('admin.clearData');

///////////////////// IMPORT
////POINTS 
Route::get('/importone', [ImportPointController::class, 'showImportForm'])->name('import.point');

Route::post('/importe', [ImportPointController::class, 'import'])->name('import.points');

//LES DEUX 
Route::get('/importtwo', [ImportTwoCsvController::class, 'showImportForm'])->name('import.importTwo');
Route::post('/import', [ImportTwoCsvController::class, 'importTwoCsv'])->name('importTwoCsv');


// Pénalité

Route::get('/penalties', [PenaltyController::class, 'show'])->name('penalties.show');
Route::delete('/penalties/{id}', [PenaltyController::class, 'destroy'])->name('penalties.destroy');
Route::get('/penalties/create', [PenaltyController::class, 'create'])->name('penalties.create');
Route::post('/penalties', [PenaltyController::class, 'store'])->name('penalties.store');


// MODEL certificat
Route::get('/certificate/model', [CertificateController::class, 'showModel'])->name('certificate.model');
Route::get('/download-certificate/{team}/{category}', [CertificateController::class , 'download'])->name('downloadCertificate');


// selectionner une etape et afficher  le rang de ses coureurs 
Route::get('/step/{id}/results', [StepController::class ,'showResults'])->name('step.showResults');


//afficher le point de l'equipe par etapes
// routes/web.php

Route::get('/team/{team_name}/stage-points', [RankingController::class, 'teamStagePoints'])->name('teamStagePoints');
