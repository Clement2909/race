<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\UserController;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as FacadeResponse;



class AdminAuthController extends Controller
{
    // Afficher le formulaire de connexion pour l'administrateur
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Gérer la soumission du formulaire de connexion pour l'administrateur
    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->only('login', 'password');

        // Retrieve the user with the given email from the database
        $user = DB::table('users')->where('login', $credentials['login'])->first();

        // Check if a user with the given email exists and if the passwords match
        if ($user && hash_equals($user->password, hash('sha256', $credentials['password']))) {
            // Check if the user is an administrator
            if ($user->id_role == 1) {
                // Log the user in
                Auth::loginUsingId($user->id);
                $user = Auth::user();
            
                // Store the user ID in session
                Session::put('user_id', $user->id);
                return redirect()->route('admin.dashboard');
            } else {
                // Redirect the user with an error message
                return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page.');
            }
        } else {
            // Redirect the user with an error message
            return redirect()->route('admin.login')->with('error', 'Incorrect login or password.');
        }
    }

    // Afficher le tableau de bord de l'administrateur
    public function showDashboard()
    {
        // Retrieve the user's name from the authenticated user
        $userName = Auth::user()->name;
        $users = User::all();
        // Pass the user's name to the dashboard view
        return view('admin.dashboard', ['userName' => $userName], compact('users'));
    }
// export pdf tableau 
    public function exportPDF()
    {
        // Récupérer la liste des utilisateurs
        $users = User::all();

        // Générer le contenu HTML de la liste des utilisateurs dans un tableau
        $html = '<h1>Liste des utilisateurs</h1>';
        $html .= '<table border="1">';
        $html .= '<thead><tr><th>ID</th><th>Nom</th><th>Email</th></tr></thead>';
        $html .= '<tbody>';
        foreach ($users as $user) {
            $html .= "<tr><td>$user->id</td><td>$user->name</td><td>$user->email</td></tr>";
        }
        $html .= '</tbody>';
        $html .= '</table>';

        // Configuration de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Créer une instance de Dompdf
        $dompdf = new Dompdf($options);

        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendre le PDF
        $dompdf->render();

        // Télécharger le PDF
        return $dompdf->stream('users.pdf');
    }
    public function exportCSV()
    {
        // Récupérer la liste des utilisateurs
        $users = User::all();

        // Préparer les en-têtes CSV
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=users.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        // Définir le pointeur de sortie vers le tampon de sortie
        $output = fopen("php://output", "w");

        // Écrire les en-têtes CSV
        fputcsv($output, array('ID', 'Nom', 'Email'));

        // Écrire les données des utilisateurs dans le fichier CSV
        foreach ($users as $user) {
            fputcsv($output, array($user->id, $user->name, $user->email));
        }

        // Fermer le pointeur de sortie
        fclose($output);

        // Retourner la réponse CSV
        return FacadeResponse::make('', 200, $headers);
    }

    public function exportXLSX()
    {
        // Récupérer la liste des utilisateurs
        $users = User::all();

        // Créer une nouvelle instance de PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Ajouter les en-têtes du tableau
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Email');

        // Remplir les données des utilisateurs dans le tableau
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user->id);
            $sheet->setCellValue('B' . $row, $user->name);
            $sheet->setCellValue('C' . $row, $user->email);
            $row++;
        }

        // Créer un objet Writer pour écrire le fichier XLSX
        $writer = new Xlsx($spreadsheet);

        // Définir les en-têtes HTTP pour le téléchargement du fichier
        $headers = array(
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment;filename="users.xlsx"',
            'Cache-Control' => 'max-age=0',
        );

        // Retourner la réponse HTTP avec le fichier XLSX
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();
        return FacadeResponse::make($content, 200, $headers);
    }

/* export pdf tsy tableau
public function exportPDF()
    {
        // Récupérer la liste des utilisateurs
        $users = User::all();

        // Générer le contenu HTML de la liste des utilisateurs
        $html = '<h1>Liste des utilisateurs</h1><ul>';
        foreach ($users as $user) {
            $html .= "<li>ID: $user->id, Nom: $user->name, Email: $user->email</li>";
        }
        $html .= '</ul>';

        // Configuration de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Créer une instance de Dompdf
        $dompdf = new Dompdf($options);

        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendre le PDF
        $dompdf->render();

        // Télécharger le PDF
        return $dompdf->stream('users.pdf');
    }
*/


    // Déconnecter l'administrateur
    public function logout()
    {
        // Déconnexion de l'utilisateur
        Auth::logout();

        // Destruction de la session
        Session::flush();

        // Redirection vers la page de connexion avec un message de succès
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
    }

}
