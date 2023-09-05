<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class coustomer_login extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guard = 'customerlogin';
    protected $guarded = ['id'];
    protected $fillable = [
        'referrel_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
