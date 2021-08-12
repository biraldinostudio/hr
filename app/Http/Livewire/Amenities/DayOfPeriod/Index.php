<?php

namespace App\Http\Livewire\Amenities\DayOfPeriod;

use Livewire\Component;
class Index extends Component
{
    public function render(){
        return view('livewire.amenities.day-of-period.index')->extends('layouts.app')->section('content');
    }
}
