<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class CertificateController extends Controller
{
    public function showModel()
    {
        return view('certificate.model');
    }


    public function download($team, $category)
    {
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();
        
        // Générer le HTML pour le certificat en utilisant la vue Blade
        $html = view('certificate.model', compact('team', 'category'))->render();
        
        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);
        
        // Rendre le PDF
        $dompdf->render();
        
        // Télécharger le PDF avec le nom de fichier spécifié
        return $dompdf->stream('certificate.pdf');
    }
    
}
