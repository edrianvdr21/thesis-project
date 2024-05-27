<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    // [1] All Workers by Ratings
    public static function allWorkersByRatings()
    {
        $workers = self::with(['user.userProfile', 'address', 'bookings' => function ($query) {
            $query->where('status', 'Completed'); // Filter bookings by completed status
        }])->get();

        // Calculate average rating and completed bookings count for each worker
        $workers->each(function ($worker) {
            $bookings = $worker->bookings;

            if ($bookings->isNotEmpty()) {
                $worker->average_rating = $bookings->avg('rating');
                $worker->completed_count = $bookings->count();
            } else {
                $worker->average_rating = 0; // Set rating to 0 if there are no bookings
                $worker->completed_count = 0; // Set count to 0 if there are no bookings
            }
        });

        // Sort workers by average rating in descending order
        $sortedWorkers = $workers->sortByDesc('average_rating');

        return $sortedWorkers->values()->all();
    }

    // [2] All Workers by Completed Bookings
    public static function allWorkersByCompletedBookings()
    {
        $workers = self::with(['user.userProfile', 'address', 'bookings' => function ($query) {
            $query->where('status', 'Completed'); // Filter bookings by completed status
        }])->get();

        // Calculate average rating and completed bookings count for each worker
        $workers->each(function ($worker) {
            $bookings = $worker->bookings;

            if ($bookings->isNotEmpty()) {
                $worker->average_rating = $bookings->avg('rating');
                $worker->completed_count = $bookings->count();
            } else {
                $worker->average_rating = 0; // Set rating to 0 if there are no bookings
                $worker->completed_count = 0; // Set count to 0 if there are no bookings
            }
        });

        // Sort workers by completed bookings count in descending order
        $sortedWorkers = $workers->sortByDesc('completed_count');

        return $sortedWorkers->values()->all();
    }

    // [3] in Same City by Ratings
    public static function inSameCityAsLoggedInUserByRating()
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

        // Calculate average rating and count completed bookings for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
                $worker->completed_count = $completedBookings->count();
            } else {
                $worker->average_rating = null;
                $worker->completed_count = 0;
            }
        });

        // Sort workers by average rating in descending order
        $sortedWorkers = $workers->sortByDesc('average_rating');

        return $sortedWorkers->values(); // Reindex the collection
    }

    // [4] in Same City by Completed Bookings
    public static function inSameCityAsLoggedInUserByCompletedBookings()
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

        // Calculate average rating and count completed bookings for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
                $worker->completed_count = $completedBookings->count();
            } else {
                $worker->average_rating = null;
                $worker->completed_count = 0;
            }
        });

        // Sort workers by completed bookings count in descending order
        $sortedWorkers = $workers->sortByDesc('completed_count');

        return $sortedWorkers->values();
    }

    // [5] in Same Region except same city by Ratings
    public static function inSameRegionAsLoggedInUserByRating()
    {
        $user = auth()->user();

        if (!$user) {
            return collect();
        }

        $userRegionId = $user->address ? $user->address->region_id : null;

        if (!$userRegionId) {
            return collect();
        }

        $userCityId = $user->address ? $user->address->city_id : null;

        $workers = WorkerProfile::with(['user.userProfile', 'address', 'bookings'])
            ->whereHas('address', function ($query) use ($userRegionId, $userCityId) {
                $query->where('region_id', $userRegionId);
                if ($userCityId) {
                    $query->where('city_id', '!=', $userCityId);
                }
            })
            ->get();

        // Calculate average rating and count completed bookings for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
                $worker->completed_count = $completedBookings->count();
            } else {
                $worker->average_rating = null;
                $worker->completed_count = 0;
            }
        });

        // Sort workers by average rating in descending order
        $sortedWorkers = $workers->sortByDesc('average_rating');

        return $sortedWorkers->values(); // Reindex the collection
    }

    // [6] in Same Region except same city by Completed Bookings
    public static function inSameRegionAsLoggedInUserByCompletedBookings()
    {
        $user = auth()->user();

        if (!$user) {
            return collect();
        }

        $userRegionId = $user->address ? $user->address->region_id : null;

        if (!$userRegionId) {
            return collect();
        }

        $userCityId = $user->address ? $user->address->city_id : null;

        $workers = WorkerProfile::with(['user.userProfile', 'address', 'bookings'])
            ->whereHas('address', function ($query) use ($userRegionId, $userCityId) {
                $query->where('region_id', $userRegionId);
                if ($userCityId) {
                    $query->where('city_id', '!=', $userCityId);
                }
            })
            ->get();

        // Calculate average rating and count completed bookings for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
                $worker->completed_count = $completedBookings->count();
            } else {
                $worker->average_rating = null;
                $worker->completed_count = 0;
            }
        });

        // Sort workers by completed bookings count in descending order
        $sortedWorkers = $workers->sortByDesc('completed_count');

        return $sortedWorkers->values(); // Reindex the collection
    }

    // [7.1] Name of most viewed Category
    public static function getMostViewedCategory()
    {
        $userId = Auth::id();

        if (!$userId) {
            return null;
        }

        $mostViewedCategory = WorkerProfileView::where('user_id', $userId)
            ->select('category_id', DB::raw('count(*) as views'))
            ->groupBy('category_id')
            ->orderByDesc('views')
            ->first();

        if (!$mostViewedCategory) {
            return null;
        }

        return $mostViewedCategory->category->category;
    }

    // [7.2] All wokers under most viewed category
    public static function getWorkersInMostViewedCategory()
    {
        $userId = Auth::id();

        // Get the most viewed category for the authenticated user
        $mostViewedCategory = WorkerProfileView::where('user_id', $userId)
            ->select('category_id', DB::raw('count(*) as views'))
            ->groupBy('category_id')
            ->orderByDesc('views')
            ->first();

        // Check if there is a most viewed category
        if (is_null($mostViewedCategory)) {
            return collect();
        }

        $categoryId = $mostViewedCategory->category_id;

        $workers = self::where('category_id', $categoryId)
            ->whereHas('address')
            ->with(['user.userProfile', 'address', 'bookings' => function ($query) {
                $query->where('status', 'Completed'); // Filter bookings by completed status
            }])
            ->get();

        // Calculate average rating and count completed bookings for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
                $worker->completed_count = $completedBookings->count();
            } else {
                $worker->average_rating = 0; // Set rating to 0 if there are no bookings
                $worker->completed_count = 0; // Set count to 0 if there are no bookings
            }
        });

        // Sort workers by average rating in descending order
        $sortedWorkers = $workers->sortByDesc('average_rating');

        return $sortedWorkers->values();
    }

    // [8.3]Most viewed category by Completed Bookings
    public static function underMostViewedCategoryByCompletedBookings()
    {
        $userId = Auth::id();

        // Get the most viewed category for the authenticated user
        $mostViewedCategory = WorkerProfileView::where('user_id', $userId)
            ->select('category_id', DB::raw('count(*) as views'))
            ->groupBy('category_id')
            ->orderByDesc('views')
            ->first();

        // Check if there is a most viewed category
        if (is_null($mostViewedCategory)) {
            return collect();
        }

        $categoryId = $mostViewedCategory->category_id;

        $workers = self::where('category_id', $categoryId)
            ->whereHas('address')
            ->with(['user.userProfile', 'address', 'bookings' => function ($query) {
                $query->where('status', 'Completed'); // Filter bookings by completed status
            }])
            ->get();

        // Calculate average rating and count completed bookings for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
                $worker->completed_count = $completedBookings->count();
            } else {
                $worker->average_rating = 0; // Set rating to 0 if there are no bookings
                $worker->completed_count = 0; // Set count to 0 if there are no bookings
            }
        });

        // Sort workers by completed bookings count in descending order
        $sortedWorkers = $workers->sortByDesc('completed_count');

        return $sortedWorkers->values();
    }

    // [7.4] MVC, Same City by Ratings
    public static function underMostViewedCategoryInSameCityByRatings()
    {
        $userId = Auth::id();
        $user = Auth::user();

        if (!$user) {
            return collect();
        }

        $userCityId = $user->address ? $user->address->city_id : null;

        if (!$userCityId) {
            return collect();
        }

        // Get the most viewed category for the authenticated user
        $mostViewedCategory = WorkerProfileView::where('user_id', $userId)
            ->select('category_id', DB::raw('count(*) as views'))
            ->groupBy('category_id')
            ->orderByDesc('views')
            ->first();

        // Check if there is a most viewed category
        if (is_null($mostViewedCategory)) {
            return collect();
        }

        $categoryId = $mostViewedCategory->category_id;

        $workers = self::where('category_id', $categoryId)
            ->whereHas('address', function ($query) use ($userCityId) {
                $query->where('city_id', $userCityId);
            })
            ->with(['user.userProfile', 'address', 'bookings' => function ($query) {
                $query->where('status', 'Completed'); // Filter bookings by completed status
            }])
            ->get();

        // Calculate average rating for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
            } else {
                $worker->average_rating = 0; // Set rating to 0 if there are no bookings
            }
        });

        // Sort workers by average rating in descending order
        $sortedWorkers = $workers->sortByDesc('average_rating');

        return $sortedWorkers->values();
    }

    // [7.5] MVC, Same Province except Same City by Ratings
    public static function underMostViewedCategoryInSameProvinceByRatings()
    {
        $userId = Auth::id();
        $user = Auth::user();

        if (!$user) {
            return collect();
        }

        $userProvinceId = $user->address ? $user->address->province_id : null;

        if (!$userProvinceId) {
            return collect();
        }

        // Get the most viewed category for the authenticated user
        $mostViewedCategory = WorkerProfileView::where('user_id', $userId)
            ->select('category_id', DB::raw('count(*) as views'))
            ->groupBy('category_id')
            ->orderByDesc('views')
            ->first();

        // Check if there is a most viewed category
        if (is_null($mostViewedCategory)) {
            return collect();
        }

        $categoryId = $mostViewedCategory->category_id;

        $workers = self::where('category_id', $categoryId)
            ->whereHas('address', function ($query) use ($userProvinceId, $user) {
                $query->where('province_id', $userProvinceId)
                    ->where('city_id', '!=', $user->address->city_id); // Exclude workers from the same city
            })
            ->with(['user.userProfile', 'address', 'bookings' => function ($query) {
                $query->where('status', 'Completed'); // Filter bookings by completed status
            }])
            ->get();

        // Calculate average rating for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
            } else {
                $worker->average_rating = 0; // Set rating to 0 if there are no bookings
            }
        });

        // Sort workers by average rating in descending order
        $sortedWorkers = $workers->sortByDesc('average_rating');

        return $sortedWorkers->values();
    }

    // [7.6] MV, Same region except Same City and Provinceby Ratings
    public static function underMostViewedCategoryInSameRegionByRatings()
    {
        $userId = Auth::id();
        $user = Auth::user();

        if (!$user) {
            return collect();
        }

        $userRegionId = $user->address ? $user->address->region_id : null;

        if (!$userRegionId) {
            return collect();
        }

        // Get the most viewed category for the authenticated user
        $mostViewedCategory = WorkerProfileView::where('user_id', $userId)
            ->select('category_id', DB::raw('count(*) as views'))
            ->groupBy('category_id')
            ->orderByDesc('views')
            ->first();

        // Check if there is a most viewed category
        if (is_null($mostViewedCategory)) {
            return collect();
        }

        $categoryId = $mostViewedCategory->category_id;

        $workers = self::where('category_id', $categoryId)
            ->whereHas('address', function ($query) use ($userRegionId, $user) {
                $query->where('region_id', $userRegionId)
                    ->where('province_id', '!=', $user->address->province_id)
                    ->where('city_id', '!=', $user->address->city_id);
            })
            ->with(['user.userProfile', 'address', 'bookings' => function ($query) {
                $query->where('status', 'Completed'); // Filter bookings by completed status
            }])
            ->get();

        // Calculate average rating for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
            } else {
                $worker->average_rating = 0; // Set rating to 0 if there are no bookings
            }
        });

        // Sort workers by average rating in descending order
        $sortedWorkers = $workers->sortByDesc('average_rating');

        return $sortedWorkers->values();
    }



    // [8.4] Most viewed category in Same City by Completed Bookings
    public static function underMostViewedCategoryInSameCityByCompletedBookings()
    {
        $userId = Auth::id();
        $user = Auth::user();

        if (!$user) {
            return collect();
        }

        $userCityId = $user->address ? $user->address->city_id : null;

        if (!$userCityId) {
            return collect();
        }

        // Get the most viewed category for the authenticated user
        $mostViewedCategory = WorkerProfileView::where('user_id', $userId)
            ->select('category_id', DB::raw('count(*) as views'))
            ->groupBy('category_id')
            ->orderByDesc('views')
            ->first();

        // Check if there is a most viewed category
        if (is_null($mostViewedCategory)) {
            return collect();
        }

        $categoryId = $mostViewedCategory->category_id;

        $workers = self::where('category_id', $categoryId)
            ->whereHas('address', function ($query) use ($userCityId) {
                $query->where('city_id', $userCityId);
            })
            ->with(['user.userProfile', 'address', 'bookings' => function ($query) {
                $query->where('status', 'Completed'); // Filter bookings by completed status
            }])
            ->get();

        // Calculate average rating and count completed bookings for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
                $worker->completed_count = $completedBookings->count();
            } else {
                $worker->average_rating = 0; // Set rating to 0 if there are no bookings
                $worker->completed_count = 0; // Set count to 0 if there are no bookings
            }
        });

        // Sort workers by completed bookings count in descending order
        $sortedWorkers = $workers->sortByDesc('completed_count');

        return $sortedWorkers->values();
    }

    // [8.5]Most viewed category in Same Province except Same City by Completed Bookings
    public static function underMostViewedCategoryInSameProvinceByCompletedBookings()
    {
        $userId = Auth::id();
        $user = Auth::user();

        if (!$user) {
            return collect();
        }

        $userProvinceId = $user->address ? $user->address->province_id : null;

        if (!$userProvinceId) {
            return collect();
        }

        // Get the most viewed category for the authenticated user
        $mostViewedCategory = WorkerProfileView::where('user_id', $userId)
            ->select('category_id', DB::raw('count(*) as views'))
            ->groupBy('category_id')
            ->orderByDesc('views')
            ->first();

        // Check if there is a most viewed category
        if (is_null($mostViewedCategory)) {
            return collect();
        }

        $categoryId = $mostViewedCategory->category_id;

        $workers = self::where('category_id', $categoryId)
            ->whereHas('address', function ($query) use ($userProvinceId, $user) {
                $query->where('province_id', $userProvinceId)
                    ->where('city_id', '!=', $user->address->city_id); // Exclude workers from the same city
            })
            ->with(['user.userProfile', 'address', 'bookings' => function ($query) {
                $query->where('status', 'Completed'); // Filter bookings by completed status
            }])
            ->get();

        // Calculate average rating and count completed bookings for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
                $worker->completed_count = $completedBookings->count();
            } else {
                $worker->average_rating = 0; // Set rating to 0 if there are no bookings
                $worker->completed_count = 0; // Set count to 0 if there are no bookings
            }
        });

        // Sort workers by completed bookings count in descending order
        $sortedWorkers = $workers->sortByDesc('completed_count');

        return $sortedWorkers->values();
    }

    // [8.6]Most viewed category in Same Region except Same City and Province by Completed Bookings
    public static function underMostViewedCategoryInSameRegionByCompletedBookings()
    {
        $userId = Auth::id();
        $user = Auth::user();

        if (!$user) {
            return collect();
        }

        $userRegionId = $user->address ? $user->address->region_id : null;

        if (!$userRegionId) {
            return collect();
        }

        // Get the most viewed category for the authenticated user
        $mostViewedCategory = WorkerProfileView::where('user_id', $userId)
            ->select('category_id', DB::raw('count(*) as views'))
            ->groupBy('category_id')
            ->orderByDesc('views')
            ->first();

        // Check if there is a most viewed category
        if (is_null($mostViewedCategory)) {
            return collect();
        }

        $categoryId = $mostViewedCategory->category_id;

        $workers = self::where('category_id', $categoryId)
            ->whereHas('address', function ($query) use ($userRegionId, $user) {
                $query->where('region_id', $userRegionId)
                    ->where('province_id', '!=', $user->address->province_id)
                    ->where('city_id', '!=', $user->address->city_id);
            })
            ->with(['user.userProfile', 'address', 'bookings' => function ($query) {
                $query->where('status', 'Completed'); // Filter bookings by completed status
            }])
            ->get();

        // Calculate average rating and count completed bookings for each worker
        $workers->each(function ($worker) {
            $completedBookings = $worker->bookings->where('status', 'Completed');
            if ($completedBookings->isNotEmpty()) {
                $worker->average_rating = $completedBookings->avg('rating');
                $worker->completed_count = $completedBookings->count();
            } else {
                $worker->average_rating = 0; // Set rating to 0 if there are no bookings
                $worker->completed_count = 0; // Set count to 0 if there are no bookings
            }
        });

        // Sort workers by completed bookings count in descending order
        $sortedWorkers = $workers->sortByDesc('completed_count');

        return $sortedWorkers->values();
    }

}
