<?php

namespace App\Http\Livewire\Master\Position;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.master.position.index')->extends('layouts.app')->section('content');
    }
}
