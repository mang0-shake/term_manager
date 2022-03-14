<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    const USER_MANAGER = 'USER_MANAGER';
    const TERM_MANAGER = 'TERM_MANAGER';
    const TERMBASE_MANAGER = 'TERMBASE_MANAGER';

    protected $fillable = [
        'id',
        'properties',
    ];
    public function users()
    {
        return $this
            ->belongsToMany(User::class, 'users_to_privileges');
    }
}
