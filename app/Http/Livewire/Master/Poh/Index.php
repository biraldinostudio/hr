<?php

namespace App\Http\Livewire\Master\Poh;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.master.poh.index')->extends('layouts.app')->section('content');
    }
}
