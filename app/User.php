<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;  // Trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // FUNÇÃO QUE INDICA QUE ESTA CLASSE TEM UM RELACIONAMENTO 1:1 COM A CLASSE STORE
    public function store()
    {
        return $this->hasOne(Store::class);  // este usuario tem uma loja
    }

    public function orders()
    {
        return $this->hasMany(UserOrder::class);
    }

}
