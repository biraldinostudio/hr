<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Maintenance extends Component
{
    public function render()
    {
        return view('livewire.maintenance')->extends('layouts.app')->section('content');
    }
}
