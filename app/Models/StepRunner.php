<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepRunner extends Model

{
    protected $table = 'step_runner';
    public $timestamps = false;
    protected $primaryKey = 'id_step_runner';
    protected $fillable = [
        'id_step', // Ajoutez cette ligne
        'id_runner',
        'end_time',
    ];

    

    // Autres attributs et méthodes de votre modèle...
}
