<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $primaryKey = 'email';
    public $incrementing = false;

    public $timestamps = false;
    
    protected $fillable = ['email','token','code', 'expires_at']; 
}
