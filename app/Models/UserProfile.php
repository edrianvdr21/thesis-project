<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birthdate',
        'gender_id',
        'marital_status_id',
        'email_address',
        'mobile_number',
        'role_id',
    ];

    public static function getTableData()
    {
        return self::all();
    }

    public $timestamps = false;
}
