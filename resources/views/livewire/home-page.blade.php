<div>
    @include('partials.home-navbar')

    <main class="max-w-screen-lg mx-auto my-4">
        <div class="max-w-screen-lg mx-auto my-4">
            <div class="grid grid-cols-1 gap-4 my-4">
                <div class="flex items-center justify-center space-x-4">
                    <div>
                        <label class="sr-only" for="search">Search by worker's name</label>
                        <input type="text" name="search" id="search" aria-label="Search by worker's name" aria-required="true" required class="border border-vhn-primary rounded w-full py-2 px-3" placeholder="Search by worker's name" wire:model="search">
                    </div>
                    <div>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg"
                            wire:click="searchWorker"
                        >
                            Search
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="grid grid-cols-1 px-16 md:grid-cols-4 gap-4 my-4 w-full">
                    <div class="md:col-start-2">
                        <label for="category" class="sr-only text-zinc-800 text-sm font-semibold">Category</label>
                        <select
                            name="category"
                            id="category"
                            aria-label="Category"
                            class="w-full h-10 rounded-[5px] border-2 border-neutral-200 px-2"
                            data-label="Category"
                            wire:model="category"
                            wire:change="filterByCategory"
                        >
                            <option value="" selected>Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="service" class="sr-only text-zinc-800 text-sm font-semibold">Service</label>
                        <select
                            name="service"
                            id="service"
                            aria-label="Service"
                            class="w-full h-10 rounded-[5px] border-2 border-neutral-200 px-2"
                            data-label="Service"
                            wire:model="service"
                            wire:change="filterByService"
                        >
                            <option value="" selected>Select Service</option>
                            @foreach($services as $srv)
                                <option value="{{ $srv->id }}">{{ $srv->service }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>




        {{-- Default display --}}
        @if ($is_searching == 0)
            {{-- All workers / workers under most viewed category --}}
            @include('features.display-workers', ['heading2' => $mostViewedCategory , 'workers' => $workers])

            {{-- Workers in Same City --}}
            @if (!$same_city_workers->isEmpty())
                @include('features.display-workers', ['heading2' => "Workers in ". Auth()->user()->address->city->city, 'workers' => $same_city_workers])
            @endif

            {{-- Workers in Same Region except Same City --}}
            @if (!$same_region_workers->isEmpty())
                @include('features.display-workers', ['heading2' => "Discover more workers in your region", 'workers' => $same_region_workers])
            @endif
        {{-- User is Searching --}}
        @elseif ($is_searching == 1)
            @if (!$workers->isEmpty())
                @include('features.display-workers', ['heading2' => $mostViewedCategory , 'workers' => $workers])
            @else
                <div class="px-4 py-8">
                    <h2 class="text-2xl font-bold mb-4">{{ $mostViewedCategory }}</h2>
                    <p class="text-center text-gray-600 py-4">No workers available.</p>
                </div>
            @endif
        @endif
    </main>


</div>
