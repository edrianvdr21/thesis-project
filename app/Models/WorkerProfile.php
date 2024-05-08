<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerProfile extends Model
{
    use HasFactory;

    protected $table = 'worker_profiles';

    protected $fillable = [
        'user_id',
        'category_id',
        'service_id',
        'description',
        'pricing',
        'minimum_duration',
        'maximum_duration',
        'working_days',
        'start_time',
        'end_time',
        'valid_id',
        'resume',
    ];

    public static function getTableData()
    {
        return self::all();
    }

    public function userworker()
    {
        return $this->belongsTo(User::class);
    }

    public $timestamps = false;
}
