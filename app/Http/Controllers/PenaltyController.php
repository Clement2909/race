<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penalty;
use App\Models\Step;
use App\Models\User;

class PenaltyController extends Controller
{
    public function show()
    {
        // Récupérer toutes les pénalités avec les étapes et les utilisateurs associés
        $penalties = Penalty::with(['step', 'user'])->get();

        // Passer les données à la vue
        return view('penalties.show', compact('penalties'));
    }

    public function destroy($id)
    {
        $penalty = Penalty::findOrFail($id);
        $penalty->delete();

        return redirect()->route('penalties.show')->with('success', 'Penalty deleted successfully.');
    }
    public function create()
    {
        $teams = User::where('id_role', 2)->get();
        $steps = Step::all();
        return view('penalties.create', compact('teams', 'steps'));
    }
    

public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'step_id' => 'required|exists:step,id_step',
            'user_id' => 'required|exists:users,id',
            'val' => 'required|date_format:H:i:s'
        ]);

        // Création de la pénalité
        $penalty = new Penalty();
        $penalty->id_step = $request->step_id;
        $penalty->id_user = $request->user_id;
        $penalty->val = $request->val;
        $penalty->save();

        // Redirection avec un message de succès
        return redirect()->route('penalties.show')->with('success', 'Penalty added successfully.');
    }
}
