<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_last_modified';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
//        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this
            ->belongsToMany(Privilege::class, 'users_to_privileges');
    }

    //
//    public function authorizeRoles($privileges)
//
//    {
//        if ($this->hasAnyRole($privileges)) {
//            return true;
//        }
//        abort(401, 'This action is unauthorized.');
//    }
//    public function hasAnyRole($privileges)
//    {
//        if (is_array($privileges)) {
//            foreach ($privileges as $privilege) {
//                if ($this->hasRole($privilege)) {
//                    return true;
//                }
//            }
//        } else {
//            if ($this->hasRole($privileges)) {
//                return true;
//            }
//        }
//        return false;
//    }
//    public function hasRoles()
//    {
//        dd($this->roles()->pluck('name'));
////        if ($this->roles()->where('name', $privilege)->first()) {
////            return true;
////        }
////        return ;
//    }

}
