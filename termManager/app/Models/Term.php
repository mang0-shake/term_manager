<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'terms';
    protected $fillable = [
        'id',
        'properties',
    ];

    public $timestamps = false;
    protected $casts = [
        'properties' => 'array',
    ];
    use HasFactory;
}
