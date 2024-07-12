<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'points';
    protected $primaryKey = 'id_point';
    public $timestamps = false;

    // Définir les relations avec les autres modèles si nécessaire
}
