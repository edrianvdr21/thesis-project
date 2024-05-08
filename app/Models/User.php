<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username', 'password',
    ];

    public $timestamps = false;

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function workerprofile()
    {
        return $this->hasOne(WorkerProfile::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

}
