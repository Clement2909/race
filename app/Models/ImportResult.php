<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'etape_rang',
        'numero_dossard',
        'nom',
        'genre',
        'date_naissance',
        'equipe',
        'arrivee',
    ];

    public $timestamps = false; // Disable timestamps
}
