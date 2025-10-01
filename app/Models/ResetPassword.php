<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    public $timestamps = false;
    protected $table = 'password_reset_tokens';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $hidden = ['token'];
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}
