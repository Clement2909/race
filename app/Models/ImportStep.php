<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'etape',
        'longueur',
        'nb_coureur',
        'rang',
        'date_depart',
        'heure_depart',
    ];

    public $timestamps = false; // Disable timestamps
}
