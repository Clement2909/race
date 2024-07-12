<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class Step extends Model
{
    protected $table = 'step';
    protected $primaryKey = 'id_step';
    public function runners()
    {
        return $this->belongsToMany(Runner::class, 'step_runner', 'id_step', 'id_runner')
            ->withPivot('end_time');
    }
 protected $fillable = ['name', 'length', 'number_runner_foreachteam', 'rank_step', 'start_date', 'start_time'];
 public $timestamps = false;


}

