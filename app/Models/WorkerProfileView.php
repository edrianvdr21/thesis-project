<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkerProfileView extends Model
{
    use HasFactory;

    protected $table = 'worker_profile_views';

    protected $fillable = [
        'user_id',
        'worker_id',
        'category_id',
        'service_id',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];


    public $timestamps = false;

    // Defining Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function worker()
    {
        // return $this->belongsTo(WorkerProfile::class, 'worker_id');
        return $this->belongsTo(WorkerProfile::class, 'worker_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
