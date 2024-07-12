<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Step;
use App\Models\User;
use App\Models\Runner;
use App\Models\StepRunner;


class ImportTwoCsvController extends Controller
{
    // Afficher le formulaire d'importation
    public function showImportForm()
    {
        return view('import.importTwo');
    }

    public function importTwoCsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file_steps' => 'required|file|mimes:csv,txt',
            'csv_file_results' => 'required|file|mimes:csv,txt',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $stepsFile = $request->file('csv_file_steps')->getRealPath();
        $resultsFile = $request->file('csv_file_results')->getRealPath();
    
        DB::transaction(function () use ($stepsFile, $resultsFile) {
            // Traitement du fichier etape.csv
            $dataSteps = array_map('str_getcsv', file($stepsFile));
    
            // Insertion des données de etape.csv dans la table Step
            foreach ($dataSteps as $index => $rowDataSteps) {
                if ($index == 0) continue; // Ignorer la première ligne (entête)
                // Convertir la date au format YYYY-MM-DD
                $startDate = date('Y-m-d', strtotime(str_replace('/', '-', $rowDataSteps[4])));
    
                // Remplacer la virgule par un point pour le format décimal
                $length = str_replace(',', '.', $rowDataSteps[1]);
                Step::create([
                    'name' => $rowDataSteps[0],
                    'length' => $length,
                    'number_runner_foreachteam' => $rowDataSteps[2],
                    'rank_step' => $rowDataSteps[3],
                    'start_date' => $startDate,
                    'start_time' => $rowDataSteps[5],
                ]);
            }
    
            // Traitement du fichier result.csv
            $dataResults = array_map('str_getcsv', file($resultsFile));
    
            // Insertion des équipes dans la table users
            foreach ($dataResults as $index => $rowDataResult) {
                if ($index == 0) continue; // Ignorer la première ligne (entête)
                $team = $rowDataResult[5];
    
                // Vérifier si l'équipe existe déjà dans la table users
                $existingTeam = User::where('name', $team)->first();
    
                // Si l'équipe n'existe pas, l'insérer dans la table users
                if (!$existingTeam) {
                    User::create([
                        'name' => $team,
                        'login' => $team,
                        'password' =>  $team,
                        'id_role' => 2,
                    ]);
                }
            }
    
            // Insertion des coureurs dans la table runners
            foreach ($dataResults as $index => $rowDataResult) {
                if ($index == 0) continue; // Ignorer la première ligne (entête)
                $team = $rowDataResult[5];
            
                // Récupérer l'ID de l'équipe
                $teamId = User::where('name', $team)->first()->id;
            
                // Convertir la date de naissance au bon format
                $birthdate = date('Y-m-d', strtotime(str_replace('/', '-', $rowDataResult[4])));
            
                // Vérifier si le coureur existe déjà
                $existingRunner = Runner::where('numero_dossard', $rowDataResult[1])
                                         ->where('birthdate', $birthdate)
                                         ->first();
            
                // Si le coureur n'existe pas, l'insérer dans la table runners
                if (!$existingRunner) {
                    Runner::create([
                        'name' => $rowDataResult[2],
                        'numero_dossard' => $rowDataResult[1],
                        'birthdate' => $birthdate,
                        'id_genre' => ($rowDataResult[3] == 'M') ? 1 : 2, // 1 pour Male, 2 pour Female
                        'id_user' => $teamId,
                    ]);
                }
            }
    
            // Insertion des résultats dans la table step_runner
            foreach ($dataResults as $index => $rowDataResult) {
                if ($index == 0) continue; // Ignorer la première ligne (entête)
    
                // Récupérer le rang de l'étape et le numéro de dossard du coureur
                $stepRank = intval($rowDataResult[0]);
                $numeroDossard = intval($rowDataResult[1]);
    
                // Récupérer l'ID de l'étape en fonction du rang de l'étape
                $step = Step::where('rank_step', $stepRank)->first();
                if (!$step) {
                    // Log any errors or take other actions
                    logger('Step not found for rank: ' . $stepRank);
                    continue; // Passer à la ligne suivante
                }
    
                // Récupérer l'ID du coureur en fonction du numéro de dossard
                $runner = Runner::where('numero_dossard', $numeroDossard)->first();
                if (!$runner) {
                    // Log any errors or take other actions
                    logger('Runner not found for numero dossard: ' . $numeroDossard);
                    continue; // Passer à la ligne suivante
                }
    
                // Récupérer la date d'arrivée au format correct
                $formattedArrivalDate = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $rowDataResult[6])));
    
                // Insérer dans la table step_runner
                StepRunner::create([
                    'id_step' => $step->id_step,
                    'id_runner' => $runner->id_runner,
                    'end_time' => $formattedArrivalDate,
                ]);
            }
        });
    
        return redirect()->back()->with('success', 'CSV imported successfully.');
    }
}