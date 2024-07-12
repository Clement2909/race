<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 

class AdminController extends Controller {
public function clearData()
{
    DB::statement("DELETE FROM point");
    DB::statement("ALTER TABLE point AUTO_INCREMENT= 1 ");
    DB::statement("DELETE FROM penalty");
    DB::statement("ALTER TABLE penalty AUTO_INCREMENT= 1 ");
    DB::statement("DELETE FROM step_runner");
    DB::statement("ALTER TABLE step_runner AUTO_INCREMENT= 1 ");
    DB::statement("DELETE FROM step");
    DB::statement("ALTER TABLE step AUTO_INCREMENT= 1 ");
    DB::statement("DELETE FROM category_runner");
    DB::statement("ALTER TABLE category_runner AUTO_INCREMENT= 1 ");
    DB::statement("DELETE FROM runners");
    DB::statement("ALTER TABLE runners AUTO_INCREMENT= 1 ");
    DB::statement("DELETE FROM users WHERE id_role = 2");
    DB::statement("ALTER TABLE users AUTO_INCREMENT= 6 ");

    // Redirigez l'utilisateur quelque part après l'exécution des requêtes
    return redirect()->route('admin.dashboard')->with('success', 'Données effacées avec succès.');
}
}