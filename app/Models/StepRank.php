<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepRank extends Model
{
    protected $table = 'step_rank';
    protected $primaryKey = 'id_step_runner';
    public $timestamps = false;

    // Définir les relations avec les autres modèles si nécessaire
}
