<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\UserProfile;
use App\Models\User;
use App\Models\WorkerProfile;
use App\Models\WorkerProfileView;
use App\Models\Booking;

use App\Models\Category;
use App\Models\Service;

class HomePage extends Component
{
    // Search and Filter
    public $is_searching = 0;
    public $search;
    public $category;
    public $service;
    public $categories;
    public $services;

    // For displaying workers
    public $random_value;
    public $workers;
    public $same_city_workers;
    public $same_region_workers;
    public $mostViewedCategory;

    // MVC = Most Viewed Category
    public $mvc_same_city_workers;
    public $mvc_same_province_workers;
    public $mvc_same_region_workers;


    public function mount()
    {
        // Category and Service
        $this->categories = Category::all();
        $this->services = collect();

        $this->random_value = rand(1, 2);
        // 1 = sort by Ratings
        // 2 = sort by Completed Bookings

        // Recommend workers under the user's most viewed category
        $this->mostViewedCategory = WorkerProfile::getMostViewedCategory();
        if ($this->mostViewedCategory == "") {
            //Ifnf user hasn't viewed any worker's profile yet, display all workers
            if ($this->random_value == 1) {
                $this->mostViewedCategory = "Most Rated";
                $this->workers = WorkerProfile::allWorkersByRatings();
            }
            else if ($this->random_value == 2) {
                $this->mostViewedCategory = "Most Completed Bookings";
                $this->workers = WorkerProfile::allWorkersByCompletedBookings();
            }
        }
        else if ($this->mostViewedCategory != "") {
            if ($this->random_value == 1) {
                $this->mvc_same_city_workers = WorkerProfile::underMostViewedCategoryInSameCityByRatings();
                $this->mvc_same_province_workers = WorkerProfile::underMostViewedCategoryInSameProvinceByRatings();
                $this->mvc_same_region_workers = WorkerProfile::underMostViewedCategoryInSameRegionByRatings();

                $this->workers = $this->mvc_same_city_workers
                    ->concat($this->mvc_same_province_workers);
                    // ->concat($this->mvc_same_region_workers);
            }
            else if ($this->random_value == 2) {
                $this->mvc_same_city_workers = WorkerProfile::underMostViewedCategoryInSameCityByCompletedBookings();
                $this->mvc_same_province_workers = WorkerProfile::underMostViewedCategoryInSameProvinceByCompletedBookings();
                $this->mvc_same_region_workers = WorkerProfile::underMostViewedCategoryInSameRegionByCompletedBookings();

                $this->workers = $this->mvc_same_city_workers
                    ->concat($this->mvc_same_province_workers);
                    // ->concat($this->mvc_same_region_workers);
            }
        }

        if ($this->random_value == 1) {
            // Workers in Same City
            $this->same_city_workers = WorkerProfile::inSameCityAsLoggedInUserByRating();
            // Workers in Same Region except same city
            $this->same_region_workers = WorkerProfile::inSameRegionAsLoggedInUserByRating();
        } else if ($this->random_value == 2) {
            $this->same_city_workers = WorkerProfile::inSameCityAsLoggedInUserByCompletedBookings();
            $this->same_region_workers = WorkerProfile::inSameRegionAsLoggedInUserByCompletedBookings();
        }
    }

    // Filter by Category
    public function filterByCategory()
    {
        $this->services = Service::where('category_id', $this->category)->get();

        $this->is_searching = 1;

        $query = WorkerProfile::query();

        if (!empty($this->category)) {
            $query->where('category_id', $this->category);
            $category = Category::find($this->category);
            $this->mostViewedCategory = $category ? $category->category : null;

            $this->workers = $query->get();
        } else {
            $this->mostViewedCategory = WorkerProfile::getMostViewedCategory();
            if ($this->mostViewedCategory == "") {
                //Ifnf user hasn't viewed any worker's profile yet, display all workers
                if ($this->random_value == 1) {
                    $this->mostViewedCategory = "Most Rated";
                    $this->workers = WorkerProfile::allWorkersByRatings();
                }
                else if ($this->random_value == 2) {
                    $this->mostViewedCategory = "Most Completed Bookings";
                    $this->workers = WorkerProfile::allWorkersByCompletedBookings();
                }
            }
            else if ($this->mostViewedCategory != "") {
                if ($this->random_value == 1) {
                    $this->mvc_same_city_workers = WorkerProfile::underMostViewedCategoryInSameCityByRatings();
                    $this->mvc_same_province_workers = WorkerProfile::underMostViewedCategoryInSameProvinceByRatings();
                    $this->mvc_same_region_workers = WorkerProfile::underMostViewedCategoryInSameRegionByRatings();

                    $this->workers = $this->mvc_same_city_workers
                        ->concat($this->mvc_same_province_workers);
                        // ->concat($this->mvc_same_region_workers);
                }
                else if ($this->random_value == 2) {
                    $this->mvc_same_city_workers = WorkerProfile::underMostViewedCategoryInSameCityByCompletedBookings();
                    $this->mvc_same_province_workers = WorkerProfile::underMostViewedCategoryInSameProvinceByCompletedBookings();
                    $this->mvc_same_region_workers = WorkerProfile::underMostViewedCategoryInSameRegionByCompletedBookings();

                    $this->workers = $this->mvc_same_city_workers
                        ->concat($this->mvc_same_province_workers);
                        // ->concat($this->mvc_same_region_workers);
                }
            }
        }


        if (!empty($this->search)) {
            $searchTerms = explode(' ', $this->search);

            $query->whereHas('user.userProfile', function ($subquery) use ($searchTerms) {
                $subquery->where(function ($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $q->where('first_name', 'like', '%' . $term . '%')
                          ->orWhere('middle_name', 'like', '%' . $term . '%')
                          ->orWhere('last_name', 'like', '%' . $term . '%');
                    }
                });
            });

            $this->workers = $query->get();
        }

    }

    // Filter by Service
    public function filterByService()
    {
        $query = WorkerProfile::query();

        // Variables to store the names
        $categoryName = null;
        $serviceName = null;

        // Fetch and concatenate the names
        if (!empty($this->service)) {
            $service = Service::find($this->service);
            $serviceName = $service ? $service->service : null;

            $category = $service ? $service->category : null;
            $categoryName = $category ? $category->category : null;

            $query->where('service_id', $this->service);


        } else if (!empty($this->category)) {
            $category = Category::find($this->category);
            $categoryName = $category ? $category->category : null;

            $query->where('category_id', $this->category);
        } else {
            $this->mostViewedCategory = WorkerProfile::getMostViewedCategory();
        }

        if (!empty($this->search)) {
            $searchTerms = explode(' ', $this->search);

            $query->whereHas('user.userProfile', function ($subquery) use ($searchTerms) {
                $subquery->where(function ($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $q->where('first_name', 'like', '%' . $term . '%')
                        ->orWhere('middle_name', 'like', '%' . $term . '%')
                        ->orWhere('last_name', 'like', '%' . $term . '%');
                    }
                });
            });
        }

        $this->workers = $query->get();
        $this->is_searching = 1;

        // Set the mostViewedCategory property to the concatenated string
        if ($categoryName && $serviceName) {
            $this->mostViewedCategory = "$categoryName > $serviceName";
        } else if ($categoryName) {
            $this->mostViewedCategory = $categoryName;
        } else if (!$this->mostViewedCategory) {
            $this->mostViewedCategory = WorkerProfile::getMostViewedCategory();
            if ($this->mostViewedCategory == "") {
                //Ifnf user hasn't viewed any worker's profile yet, display all workers
                if ($this->random_value == 1) {
                    $this->mostViewedCategory = "Most Rated";
                    $this->workers = WorkerProfile::allWorkersByRatings();
                }
                else if ($this->random_value == 2) {
                    $this->mostViewedCategory = "Most Completed Bookings";
                    $this->workers = WorkerProfile::allWorkersByCompletedBookings();
                }
            }
            else if ($this->mostViewedCategory != "") {
                if ($this->random_value == 1) {
                    $this->mvc_same_city_workers = WorkerProfile::underMostViewedCategoryInSameCityByRatings();
                    $this->mvc_same_province_workers = WorkerProfile::underMostViewedCategoryInSameProvinceByRatings();
                    $this->mvc_same_region_workers = WorkerProfile::underMostViewedCategoryInSameRegionByRatings();

                    $this->workers = $this->mvc_same_city_workers
                        ->concat($this->mvc_same_province_workers);
                        // ->concat($this->mvc_same_region_workers);
                }
                else if ($this->random_value == 2) {
                    $this->mvc_same_city_workers = WorkerProfile::underMostViewedCategoryInSameCityByCompletedBookings();
                    $this->mvc_same_province_workers = WorkerProfile::underMostViewedCategoryInSameProvinceByCompletedBookings();
                    $this->mvc_same_region_workers = WorkerProfile::underMostViewedCategoryInSameRegionByCompletedBookings();

                    $this->workers = $this->mvc_same_city_workers
                        ->concat($this->mvc_same_province_workers);
                        // ->concat($this->mvc_same_region_workers);
                }
            }
        }
    }



    public function searchWorker()
    {
        $this->is_searching = 1;

        $query = WorkerProfile::query();

        if (!empty($this->search)) {
            $searchTerms = explode(' ', $this->search);

            $query->whereHas('user.userProfile', function ($subquery) use ($searchTerms) {
                $subquery->where(function ($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $q->where('first_name', 'like', '%' . $term . '%')
                          ->orWhere('middle_name', 'like', '%' . $term . '%')
                          ->orWhere('last_name', 'like', '%' . $term . '%');
                    }
                });
            });
        }

        $this->workers = $query->get();
    }

    public function render()
    {
        return view('livewire.home-page');
    }

}
