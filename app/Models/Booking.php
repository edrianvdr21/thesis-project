<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'worker_id',
        'date',
        'time',
        'notes',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workerProfile()
    {
        return $this->belongsTo(WorkerProfile::class, 'worker_id');
    }

    public $timestamps = false;
}