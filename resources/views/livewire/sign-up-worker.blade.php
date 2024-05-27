@include('partials.home-navbar')

<main>

    <h1>Become a Worker</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h2>Worker Information</h2>

    <label for="category">Category</label>
    <select name="category" id="category" required wire:model="category" wire:change="loadServices">
        <option value="" selected>Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category }}</option>
        @endforeach
    </select>

    <label for="service">Service</label>
    <select name="service" id="service" required wire:model="service">
        <option value="" selected>Select Service</option>
        @foreach($services as $service)
            <option value="{{ $service->id }}">{{ $service->service }}</option>
        @endforeach
    </select>

    <label for="description">Description</label>
    <textarea rows=5 name="description" id="description" required wire:model="description"></textarea>

    <label for="pricing">Pricing</label>
    <input type="number" name="pricing" id="pricing" required wire:model="pricing">

    <label for="minimum_duration">Minimum Duration</label>
    <input type="number" name="minimum_duration" id="minimum_duration" required wire:model="minimum_duration">

    <label for="maximum_duration">Maximum Duration</label>
    <input type="number" name="maximum_duration" id="maximum_duration" required wire:model="maximum_duration">

    <label for="working_days">Working Days</label>

        <input type="checkbox" id="sunday" name="sunday" value="sunday" wire:model="working_days.sunday">
        <label for="sunday">Sunday</label>


        <input type="checkbox" id="monday" name="monday" value="monday" wire:model="working_days.monday">
        <label for="monday">Monday</label>


        <input type="checkbox" id="tuesday" name="tuesday" value="tuesday" wire:model="working_days.tuesday">
        <label for="tuesday">Tuesday</label>


        <input type="checkbox" id="wednesday" name="wednesday" value="wednesday" wire:model="working_days.wednesday">
        <label for="wednesday">Wednesday</label>


        <input type="checkbox" id="thursday" name="thursday" value="thursday" wire:model="working_days.thursday">
        <label for="thursday">Thursday</label>


        <input type="checkbox" id="friday" name="friday" value="friday" wire:model="working_days.friday">
        <label for="friday">Friday</label>


        <input type="checkbox" id="saturday" name="saturday" value="saturday" wire:model="working_days.saturday">
        <label for="saturday">Saturday</label>


    <label for="start_time">Start Time</label>
    <input type="time" name="start_time" id="start_time" required wire:model="start_time">

    <label for="end_time">End Time</label>
    <input type="time" name="end_time" id="end_time" required wire:model="end_time">

    <label for="valid_id">Upload a Picture of Valid ID</label>
    <input type="file" accept="image/*" name="valid_id" id="valid_id" wire:model="valid_id">

    <label for="resume">Upload Resume</label>
    <input type="file" accept=".pdf,.doc,.docx" name="resume" id="resume" wire:model="resume">

    <button wire:click="sign_up_as_a_worker">Sign Up as a Worker</button>
</main>
