<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Step;
use App\Models\StepRunner;
use Illuminate\Support\Facades\DB;

class StepController extends Controller
{
    public function index()
    {
        $steps = Step::all();
        
        return view('steps.index', ['steps' => $steps]);
    }


    public function index1()
{
    // Récupérer l'utilisateur connecté
    $user_id = auth()->user()->id;

    // Récupérer toutes les étapes
    $steps = Step::all();

    // Charger le nombre de coureurs affectés à chaque étape et leurs chronos
    foreach ($steps as $step) {
        $step->runners_count = StepRunner::where('id_step', $step->id_step)->count();

        // Charger les coureurs de l'équipe connectée pour chaque étape avec leurs chronos
        $step->runners = DB::table('step_runner')
            ->join('runners', 'step_runner.id_runner', '=', 'runners.id_runner')
            ->join('users', 'runners.id_user', '=', 'users.id')
            ->select('runners.name', 
                DB::raw('
                    CASE
                        WHEN TIMESTAMPDIFF(SECOND, step_runner.start_time,TIME( step_runner.end_time)) < 0 
                        THEN ADDTIME(TIMEDIFF(TIME(step_runner.end_time), step_runner.start_time), "24:00:00")
                        ELSE TIMEDIFF(TIME(step_runner.end_time), step_runner.start_time)
                    END as chrono
                ')
            )
            ->where('step_runner.id_step', $step->id_step)
            ->where('runners.id_user', $user_id)
            ->get();

        // Compter le nombre de coureurs de l'utilisateur connecté pour cette étape
        $step->user_runners_count = StepRunner::where('id_step', $step->id_step)
            ->whereIn('id_runner', function($query) use ($user_id) {
                $query->select('id_runner')
                    ->from('runners')
                    ->where('id_user', $user_id);
            })
            ->count();

        // S'assurer que le nombre requis de coureurs est disponible
        $step->number_runner_foreachteam = $step->number_runner_foreachteam;
    }

    return view('steps.indexteam', ['steps' => $steps]);
}

public function showResults($id)
    {
        // Récupérer les détails de l'étape
        $step = Step::findOrFail($id);

        // Utiliser la vue `step_rank` pour récupérer les informations nécessaires
        $stepRanks = DB::table('step_rank')
            ->select(
                'step_rank.id_step',
                'step.name AS step_name',
                'step.start_date AS start_date',
                'step_rank.id_runner',
                'step_rank.runner_name AS participant_name',
                'users.name AS participant_team',
                'step_rank.participant_rank',
                'point.points AS points_awarded',
                'step_rank.start_time',
                'step_rank.end_time',
                'step_rank.chrono',
                'step_rank.total_penalty AS total_penalty',
                'runners.id_genre as idgenre',
                'step_rank.chrono_final AS chrono_final'
            )
            ->join('step', 'step_rank.id_step', '=', 'step.id_step')
            ->join('point', 'step_rank.participant_rank', '=', 'point.rank_runner')
            ->join('runners', 'step_rank.id_runner', '=', 'runners.id_runner')
            ->join('users', 'runners.id_user', '=', 'users.id') // 'users' est la table contenant les noms d'équipe
            ->where('step_rank.id_step', $id)  // Changer ici pour utiliser l'ID de l'étape passée en paramètre
            ->orderBy('step_rank.participant_rank')
            ->paginate(10); // Nombre de résultats par page

        // Obtenir la liste des étapes pour la navigation
        $steps = Step::all();

        return view('steps.results', [
            'stepRanks' => $stepRanks,
            'steps' => $steps,
            'currentStep' => $id
        ]);
    }
}
    
