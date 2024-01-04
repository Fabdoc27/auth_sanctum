<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, Notifiable;

    protected $fillable   = ['firstName', 'lastName', 'email', 'mobile', 'password', 'otp'];
    protected $attributes = ['otp' => '0'];
    protected $hidden     = ['otp'];
}