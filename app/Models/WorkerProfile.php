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

    public $timestamps = false;

    // Defining Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'user_id', 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'worker_id', 'id');
    }

    // Query
    // Get workers with their average rating
    public static function withRatings()
    {
        $workers = self::with(['user.userProfile', 'address', 'bookings'])->get();

        $workers->each(function ($worker) {
            $bookings = $worker->bookings;
            if ($bookings->isNotEmpty()) {
                $worker->average_rating = $bookings->avg('rating');
                $worker->bookings_count = $bookings->count();
            } else {
                $worker->average_rating = null;
            }
        });

        return $workers;
    }
    // Method to fetch workers in the same city as the logged-in user
    public static function inSameCityAsLoggedInUser()
    {
        $user = auth()->user();

    if (!$user) {
        return collect();
    }

    $userCityId = $user->address ? $user->address->city_id : null;

    if (!$userCityId) {
        return collect();
    }

    $workers = WorkerProfile::with(['user.userProfile', 'address', 'bookings'])
        ->whereHas('address', function ($query) use ($userCityId) {
            $query->where('city_id', $userCityId);
        })
        ->get();

    // Calculate average rating and count bookings for each worker
    $workers->each(function ($worker) {
        $bookings = $worker->bookings;
        if ($bookings->isNotEmpty()) {
            $worker->average_rating = $bookings->avg('rating');
            $worker->bookings_count = $bookings->count();
        } else {
            $worker->average_rating = null;
            $worker->bookings_count = 0;
        }
    });

    return $workers;

    }


}
