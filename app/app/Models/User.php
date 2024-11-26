<?php

namespace App\models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * 代入可能な属性を定義
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 
    ];

    /**
     * 隠すべき属性を定義
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
