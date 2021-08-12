<?php

namespace App\Http\Livewire\Amenities\LumpSum;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.amenities.lump-sum.index')->extends('layouts.app')->section('content');
    }
}
