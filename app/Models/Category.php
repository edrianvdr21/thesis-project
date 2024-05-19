<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    public static function getTableData()
    {
        return self::all();
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'category_id');
    }
}
