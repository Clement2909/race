<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Step;
use App\Models\Runner;
use App\Models\StepRunner;
use Illuminate\Support\Facades\Auth;

class RunnerController extends Controller
{
    public function selectRunners($step_id, $remaining_runner)
{
    // Récupérer les détails de l'étape
    $step = Step::findOrFail($step_id);

    // Vérifier si le nombre de coureurs affectés est déjà suffisant
    if ($step->runners_count >= $step->number_runner_foreachteam) {
        return redirect()->back()->withErrors(['message' => 'Le nombre maximum de coureurs est déjà atteint pour cette étape.']);
    }

    // Récupérer les coureurs de l'équipe connectée qui ne sont pas encore affectés à cette étape
    $teamRunners = Runner::where('id_user', auth()->user()->id)
                    ->whereNotIn('id_runner', function ($query) use ($step_id) {
                        $query->select('id_runner')
                              ->from('step_runner')
                              ->where('id_step', $step_id);
                    })
                    ->get();

    $rest = $remaining_runner;

    // Passer les données à la vue
    return view('select_runners', compact('step', 'teamRunners', 'rest'));
}


public function storeSelectedRunners(Request $request, $step_id,$rest)
{
    // Récupérer les détails de l'étape
    $step = Step::findOrFail($step_id);

    // Calculer le nombre de coureurs manquants pour cette étape
    $missingRunnersCount = $rest;
    // Vérifier si le nombre total de coureurs sélectionnés est égal au nombre de coureurs manquants
    $selectedRunnersCount = count($request->selectedRunners);
    if ($selectedRunnersCount != $missingRunnersCount) {
        return redirect()->back()->withErrors(['message' => 'Vous devez sélectionner exactement ' . $missingRunnersCount . ' coureur(s) pour cette étape.']);
    }

    // Insérer les coureurs sélectionnés
    foreach ($request->selectedRunners as $runnerId) {
        // Vérifier si le coureur appartient à l'équipe connectée
        $runner = Runner::where('id_runner', $runnerId)->where('id_user', auth()->user()->id)->first();
        if ($runner) {
            // Associer le coureur à l'étape
            $step->runners()->attach($runnerId);
        }
    }

    // Rediriger l'utilisateur avec un message de succès
    return redirect()->route('steps.indexteam')->with('success', 'Les coureurs ont été affectés avec succès à l\'étape.');


}
}
