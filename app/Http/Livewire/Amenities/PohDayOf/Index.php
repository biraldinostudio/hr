<?php

namespace App\Http\Livewire\Amenities\PohDayOf;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.amenities.poh-day-of.index')->extends('layouts.app')->section('content');
    }
}
