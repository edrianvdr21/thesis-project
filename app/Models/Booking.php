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
        'booked_datetime',
        'cancelled_datetime',
        'cancelled_by',
        'accepted_datetime',
        'completed_datetime',
        'rating',
        'review',
    ];

    public $timestamps = false;

    // Defining Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function workerProfile()
    {
        return $this->belongsTo(WorkerProfile::class, 'worker_id');
    }
    public function worker()
    {
        return $this->belongsTo(WorkerProfile::class, 'worker_id');
    }

    // Query
    // Method to fetch client bookings with optional status filter
    public static function clientBookings($userId, $filterByStatus = null)
    {
        $query = self::with('user')->where('user_id', $userId);

        if ($filterByStatus) {
            $query->where('status', $filterByStatus);
        }

        return $query->get();
    }

    // Method to fetch worker bookings with optional status filter
    public static function workerBookings($userId, $filterByStatus = null)
    {
        $query = self::with('workerProfile.user')
            ->whereHas('workerProfile.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            });

        if ($filterByStatus) {
            $query->where('status', $filterByStatus);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    // Method to count bookings statuses for client
    public static function countClientStatuses($userId)
    {
        return self::where('user_id', $userId)
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(case when status = "Pending" then 1 else 0 end) as pending_count')
            ->selectRaw('SUM(case when status = "Accepted" then 1 else 0 end) as accepted_count')
            ->selectRaw('SUM(case when status = "Completed" then 1 else 0 end) as completed_count')
            ->selectRaw('SUM(case when status = "Cancelled" then 1 else 0 end) as cancelled_count')
            ->first();
    }

    // Method to count bookings statuses for worker
    public static function countWorkerStatuses($userId)
    {
        return [
            'total' => self::whereHas('workerProfile.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->count(),

            'pending_count' => self::whereHas('workerProfile.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->where('status', 'Pending')->count(),

            'accepted_count' => self::whereHas('workerProfile.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->where('status', 'Accepted')->count(),

            'completed_count' => self::whereHas('workerProfile.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->where('status', 'Completed')->count(),

            'cancelled_count' => self::whereHas('workerProfile.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->where('status', 'Cancelled')->count(),
        ];
    }

}
