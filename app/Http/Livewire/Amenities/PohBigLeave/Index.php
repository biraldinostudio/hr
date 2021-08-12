<?php

namespace App\Http\Livewire\Amenities\PohBigLeave;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.amenities.poh-big-leave.index')->extends('layouts.app')->section('content');
    }
}
