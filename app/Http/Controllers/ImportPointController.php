<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportPoint;
use Illuminate\Support\Facades\Validator;

class ImportPointController extends Controller
{
    public function showImportForm()
    {
        return view('import.point');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);
    
        $rankInserted = [];
    
        foreach ($data as $row) {
            $rowData = array_combine($header, $row);
            $rank = $rowData['classement'];
            ImportPoint::create([
                'rank_runner' => $rank,
                'points' => $rowData['points'],
            ]);
            $rankInserted[] = $rank;
        }
    
        // Ajouter les rangs manquants jusqu'à 50 avec des points égaux à 0
        for ($i = 1; $i <= 50; $i++) {
            if (!in_array($i, $rankInserted)) {
                ImportPoint::create([
                    'rank_runner' => $i,
                    'points' => 0,
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'POINT imported successfully.');
    }
    

}
