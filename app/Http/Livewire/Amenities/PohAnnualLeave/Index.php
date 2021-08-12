<?php

namespace App\Http\Livewire\Amenities\PohAnnualLeave;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.amenities.poh-annual-leave.index')->extends('layouts.app')->section('content');
    }
}
