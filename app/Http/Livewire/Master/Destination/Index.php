<?php

namespace App\Http\Livewire\Master\Destination;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.master.destination.index')->extends('layouts.app')->section('content');
    }
}
