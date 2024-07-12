<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Runner extends Model
{
    protected $table = 'runners';
    protected $primaryKey = 'id_runner';
    public $timestamps = false;
    protected $fillable = ['name', 'numero_dossard', 'birthdate', 'id_genre', 'id_user'];
    public function steps()
    {
        return $this->belongsToMany(Step::class, 'step_runner', 'id_runner', 'id_step')
            ->withPivot('end_time');
    }

    // Définir les relations avec les autres modèles si nécessaire
}
