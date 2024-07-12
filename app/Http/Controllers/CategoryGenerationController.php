<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryGenerationController extends Controller
{
    public function assignCategoriesAutomatically()
    {
        // Sélectionner les coureurs avec leur date de naissance et genre
        $runners = DB::table('runners')->select('id_runner', 'birthdate', 'id_genre')->get();

        // Catégories pré-définies avec leurs ID
        $categories = [
            'Male' => 1,
            'Female' => 2,
            'Junior' => 3,
            'Senior' => 4,
        ];

        foreach ($runners as $runner) {
            $runnerId = $runner->id_runner;
            $birthdate = $runner->birthdate;
            $genreId = $runner->id_genre;

            // Utiliser la fonction MySQL pour calculer l'âge à partir de la date de naissance
            $ageQuery = DB::select("SELECT calculer_age(?) AS age", [$birthdate]);
            $age = $ageQuery[0]->age;

            // Assigner le coureur à la catégorie correspondante en fonction de l'âge
            if ($age < 18) {
                DB::table('category_runner')->insert([
                    'id_runner' => $runnerId,
                    'id_category' => $categories['Junior']
                ]);
            } else {
                DB::table('category_runner')->insert([
                    'id_runner' => $runnerId,
                    'id_category' => $categories['Senior']
                ]);
            }

            // Assigner le coureur à la catégorie de genre
            if ($genreId == 1) {
                DB::table('category_runner')->insert([
                    'id_runner' => $runnerId,
                    'id_category' => $categories['Male']
                ]);
            } elseif ($genreId == 2) {
                DB::table('category_runner')->insert([
                    'id_runner' => $runnerId,
                    'id_category' => $categories['Female']
                ]);
            }
        }

        return redirect()->back()->with('success', 'Categories assigned successfully.');
    }
}
