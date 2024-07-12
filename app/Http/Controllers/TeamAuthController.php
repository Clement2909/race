<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Models\User;
use Dompdf\Options;


class TeamAuthController extends Controller
{
    // Afficher le formulaire de connexion pour l'utilisateur
    public function showLoginForm()
    {
        return view('team.auth.login');
    }

    // Gérer la soumission du formulaire de connexion pour l'utilisateur
    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->only('login', 'password');

        // Retrieve the user with the given email from the database
        $user = DB::table('users')->where('login', $credentials['login'])->first();

        // Check if a user with the given email exists and if the passwords match
        if ($user && password_verify($credentials['password'], $user->password)) {
            // Check if the user is an administrator
            if ($user->id_role == 2) {
                // Log the user in
                Auth::loginUsingId($user->id);
                $user = Auth::user();
            
                // Store the user ID in session
                Session::put('user_id', $user->id);
                return redirect()->route('steps.indexteam');
            } else {
                // Redirect the user with an error message
                return redirect()->route('team.login')->with('error', 'Incorrect login or password.');
            }
        } else {
            // Redirect the user with an error message
            return redirect()->route('team.login')->with('error', 'Incorrect login or password.');
        }
    }
    

    // Afficher le tableau de bord de l'utilisateur
    public function showDashboard()
{
    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Récupérer le nom de l'utilisateur connecté
    $userName = $user->name;

    // Récupérer les projets de l'utilisateur connecté avec leur total de coût
    // Passer les projets de l'utilisateur et son nom à la vue
    return view('team.dashboard', ['userName' => $userName]);
}



public function logout()
{
    // Déconnexion de l'utilisateur
    Auth::logout();

    // Destruction de la session
    Session::flush();

    // Redirection vers la page de connexion avec un message de succès
    return redirect()->route('team.login')->with('success', 'You have been logged out successfully.');
}
}
