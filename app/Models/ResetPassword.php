<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    protected $table = 'password_reset_tokens';
    protected $primaryKey = 'email';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $hidden = ['token'];
    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}
