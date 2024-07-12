<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportPoint extends Model
{
    use HasFactory;

    protected $table = 'point';
    public $timestamps = false;

    protected $fillable = ['rank_runner', 'points'];
}
