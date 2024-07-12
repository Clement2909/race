<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StepRank;
use App\Models\Step;
use App\Models\Point;
use App\Models\Runner;
use App\Models\StepRunner;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index(Request $request)
{
    // Définir le numéro d'étape courant. Par défaut, c'est l'étape 1.
    $currentStep = $request->query('step', 1);

    // Utiliser DB Facade pour récupérer les informations nécessaires depuis la table race_dw.step_rank
    $stepRanks = DB::table('race_dw.step_rank')
        ->select([
            'id_step',
            'step_name',
            'start_date',
            'id_runner',
            'runner_name AS participant_name',
            'participant_team',
            'participant_rank',
            'start_time',
            'end_time',
            'chrono',
            'total_penalty',
            'chrono_final',
            'points_awarded'
        ])
        ->where('id_step', $currentStep)
        ->orderBy('participant_rank')
        ->paginate(10); // Nombre de résultats par page

    // Obtenir la liste des étapes pour la navigation
    $steps = Step::all();

    return view('ranking.index', [
        'stepRanks' => $stepRanks,
        'steps' => $steps,
        'currentStep' => $currentStep
    ]);
}
    
/*
public function index(Request $request)
    {
        // Définir le numéro d'étape courant. Par défaut, c'est l'étape 1.
        $currentStep = $request->query('step', 1);
    
        // Utiliser la vue step_rank pour récupérer les informations nécessaires
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
                'step_rank.chrono_final AS chrono_final'
            )
            ->join('step', 'step_rank.id_step', '=', 'step.id_step')
            ->join('point', 'step_rank.participant_rank', '=', 'point.rank_runner')
            ->join('runners', 'step_rank.id_runner', '=', 'runners.id_runner')
            ->join('users', 'runners.id_user', '=', 'users.id') // 'users' est la table contenant les noms d'équipe
            ->where('step_rank.id_step', $currentStep)
            ->orderBy('step_rank.participant_rank')
            ->paginate(10); // Nombre de résultats par page
    
        // Obtenir la liste des étapes pour la navigation
        $steps = Step::all();
    
        return view('ranking.index', [
            'stepRanks' => $stepRanks,
            'steps' => $steps,
            'currentStep' => $currentStep
        ]);
    }*/



    

public function teamRank()
{
    $teamRanks = DB::table('runners')
        ->select(
            'users.name AS team_name',
            DB::raw('SUM(point.points) AS total_points'),
            DB::raw('DENSE_RANK() OVER (ORDER BY SUM(point.points) DESC) AS team_rank')
        )
        ->join('users', 'runners.id_user', '=', 'users.id')
        ->join('step_rank', 'runners.id_runner', '=', 'step_rank.id_runner')
        ->join('point', 'step_rank.participant_rank', '=', 'point.rank_runner')
        ->groupBy('users.name')
        ->orderByDesc('total_points')
        ->get();

    return view('ranking.teamRank', ['teamRanks' => $teamRanks]);
}




    public function update(Request $request, $step)
{
    $runnerId = $request->input('runner_id');
    $endTime = $request->input('end_times.' . $runnerId);

    $stepRunner = StepRunner::where('id_step', $step)
                            ->where('id_runner', $runnerId)
                            ->firstOrFail();

    $stepRunner->end_time = $endTime;
    $stepRunner->save();

    return redirect()->back()->with('success', 'Heure d\'arrivée mise à jour avec succès.');
}





    // Team
    public function indext(Request $request)
    {
        // Définir le numéro d'étape courant. Par défaut, c'est l'étape 1.
        $currentStep = $request->query('step', 1);
    
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
                'step_rank.chrono_final AS chrono_final'
            )
            ->join('step', 'step_rank.id_step', '=', 'step.id_step')
            ->join('point', 'step_rank.participant_rank', '=', 'point.rank_runner')
            ->join('runners', 'step_rank.id_runner', '=', 'runners.id_runner')
            ->join('users', 'runners.id_user', '=', 'users.id') // 'users' est la table contenant les noms d'équipe
            ->where('step_rank.id_step', $currentStep)
            ->orderBy('step_rank.participant_rank')
            ->paginate(10); // Nombre de résultats par page
    
        // Obtenir la liste des étapes pour la navigation
        $steps = Step::all();
    
        return view('ranking.indext', [
            'stepRanks' => $stepRanks,
            'steps' => $steps,
            'currentStep' => $currentStep
        ]);
    }

    public function teamRankt()
    {
        $teamRanks = DB::table('runners')
            ->select(
                'users.name AS team_name',
                DB::raw('SUM(point.points) AS total_points'),
                DB::raw('DENSE_RANK() OVER (ORDER BY SUM(point.points) DESC) AS team_rank')
            )
            ->join('users', 'runners.id_user', '=', 'users.id')
            ->join('step_rank', 'runners.id_runner', '=', 'step_rank.id_runner')
            ->join('point', 'step_rank.participant_rank', '=', 'point.rank_runner')
            ->groupBy('users.name')
            ->orderByDesc('total_points')
            ->get();
    
        return view('ranking.teamRankt', ['teamRanks' => $teamRanks]);
    }
    
// RANG TEAM PER CATEGORY
// ADMIN
public function teamRankMale()
{
    $teamRanks = DB::table('runners')
        ->select(
            'users.name AS team_name',
            DB::raw('SUM(point.points) AS total_points'),
            DB::raw('DENSE_RANK() OVER (ORDER BY SUM(point.points) DESC) AS team_rank')
        )
        ->join('users', 'runners.id_user', '=', 'users.id')
        ->join('step_rank_male', 'runners.id_runner', '=', 'step_rank_male.id_runner')
        ->join('point', 'step_rank_male.participant_rank', '=', 'point.rank_runner')
        ->groupBy('users.name')
        ->orderByDesc('total_points')
        ->get();

    return view('ranking.rankMale', ['teamRanks' => $teamRanks]);
}



    public function teamRankFemale()
    {
        $teamRanks = DB::table('runners')
            ->select(
                'users.name AS team_name',
                DB::raw('SUM(point.points) AS total_points'),
                DB::raw('DENSE_RANK() OVER (ORDER BY SUM(point.points) DESC) AS team_rank')
            )
            ->join('users', 'runners.id_user', '=', 'users.id')
            ->join('step_rank_female', 'runners.id_runner', '=', 'step_rank_female.id_runner')
            ->join('point', 'step_rank_female.participant_rank', '=', 'point.rank_runner')
            ->groupBy('users.name')
            ->orderByDesc('total_points')
            ->get();
    
        return view('ranking.rankFemale', ['teamRanks' => $teamRanks]);
    }
    
    public function teamRankJunior()
    {
        $teamRanks = DB::table('runners')
            ->select(
                'users.name AS team_name',
                DB::raw('SUM(point.points) AS total_points'),
                DB::raw('DENSE_RANK() OVER (ORDER BY SUM(point.points) DESC) AS team_rank')
            )
            ->join('users', 'runners.id_user', '=', 'users.id')
            ->join('step_rank_junior', 'runners.id_runner', '=', 'step_rank_junior.id_runner')
            ->join('point', 'step_rank_junior.participant_rank', '=', 'point.rank_runner')
            ->groupBy('users.name')
            ->orderByDesc('total_points')
            ->get();
    
        return view('ranking.rankJunior', ['teamRanks' => $teamRanks]);
    }

    public function teamRankSenior()
    {
        $teamRanks = DB::table('runners')
            ->select(
                'users.name AS team_name',
                DB::raw('SUM(point.points) AS total_points'),
                DB::raw('DENSE_RANK() OVER (ORDER BY SUM(point.points) DESC) AS team_rank')
            )
            ->join('users', 'runners.id_user', '=', 'users.id')
            ->join('step_rank_senior', 'runners.id_runner', '=', 'step_rank_senior.id_runner')
            ->join('point', 'step_rank_senior.participant_rank', '=', 'point.rank_runner')
            ->groupBy('users.name')
            ->orderByDesc('total_points')
            ->get();
    
        return view('ranking.rankSenior', ['teamRanks' => $teamRanks]);
    }

// RANG TEAM PER CATEGORY
// TEAM
public function teamRankMalet()
{
    $teamRanks = DB::table('runners')
        ->select(
            'users.name AS team_name',
            DB::raw('SUM(point.points) AS total_points'),
            DB::raw('DENSE_RANK() OVER (ORDER BY SUM(point.points) DESC) AS team_rank')
        )
        ->join('users', 'runners.id_user', '=', 'users.id')
        ->join('step_rank_male', 'runners.id_runner', '=', 'step_rank_male.id_runner')
        ->join('point', 'step_rank_male.participant_rank', '=', 'point.rank_runner')
        ->groupBy('users.name')
        ->orderByDesc('total_points')
        ->get();

    return view('ranking.rankMalet', ['teamRanks' => $teamRanks]);
}



    public function teamRankFemalet()
    {
        $teamRanks = DB::table('runners')
            ->select(
                'users.name AS team_name',
                DB::raw('SUM(point.points) AS total_points'),
                DB::raw('DENSE_RANK() OVER (ORDER BY SUM(point.points) DESC) AS team_rank')
            )
            ->join('users', 'runners.id_user', '=', 'users.id')
            ->join('step_rank_female', 'runners.id_runner', '=', 'step_rank_female.id_runner')
            ->join('point', 'step_rank_female.participant_rank', '=', 'point.rank_runner')
            ->groupBy('users.name')
            ->orderByDesc('total_points')
            ->get();
    
        return view('ranking.rankFemalet', ['teamRanks' => $teamRanks]);
    }
    
    public function teamRankJuniort()
    {
        $teamRanks = DB::table('runners')
            ->select(
                'users.name AS team_name',
                DB::raw('SUM(point.points) AS total_points'),
                DB::raw('DENSE_RANK() OVER (ORDER BY SUM(point.points) DESC) AS team_rank')
            )
            ->join('users', 'runners.id_user', '=', 'users.id')
            ->join('step_rank_junior', 'runners.id_runner', '=', 'step_rank_junior.id_runner')
            ->join('point', 'step_rank_junior.participant_rank', '=', 'point.rank_runner')
            ->groupBy('users.name')
            ->orderByDesc('total_points')
            ->get();
    
        return view('ranking.rankJuniort', ['teamRanks' => $teamRanks]);
    }

    public function teamRankSeniort()
    {
        $teamRanks = DB::table('runners')
            ->select(
                'users.name AS team_name',
                DB::raw('SUM(point.points) AS total_points'),
                DB::raw('DENSE_RANK() OVER (ORDER BY SUM(point.points) DESC) AS team_rank')
            )
            ->join('users', 'runners.id_user', '=', 'users.id')
            ->join('step_rank_senior', 'runners.id_runner', '=', 'step_rank_senior.id_runner')
            ->join('point', 'step_rank_senior.participant_rank', '=', 'point.rank_runner')
            ->groupBy('users.name')
            ->orderByDesc('total_points')
            ->get();
    
        return view('ranking.rankSeniort', ['teamRanks' => $teamRanks]);
    }


    // app/Http/Controllers/YourController.php

    public function teamStagePoints($team_name)
    {
        // Point par étape selectionner par equipe 
        $teamStagePoints = DB::table('runners')
            ->select(
                'step.name AS stage_name',
                DB::raw('SUM(point.points) AS stage_points')
            )
            ->join('users', 'runners.id_user', '=', 'users.id')
            ->join('step_rank', 'runners.id_runner', '=', 'step_rank.id_runner')
            ->join('point', 'step_rank.participant_rank', '=', 'point.rank_runner')
            ->join('step', 'step_rank.id_step', '=', 'step.id_step') // Join with the step table to get stage names
            ->where('users.name', $team_name)
            ->groupBy('step.name')
            ->orderBy('step.name')
            ->get();
    
        return view('ranking.teamStagePoints', ['teamStagePoints' => $teamStagePoints, 'teamName' => $team_name]);
    }

}

