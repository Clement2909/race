<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $table = 'penalty';
    public $timestamps = false;

    protected $fillable = ['id_user', 'id_step', 'val'];

    public function step()
    {
        return $this->belongsTo(Step::class, 'id_step');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

