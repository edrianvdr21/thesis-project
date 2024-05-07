<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'region_id',
        'province_id',
        'city_id',
        'home_address',
    ];

    public static function getTableData()
    {
        return self::all();
    }

    public $timestamps = false;
}
