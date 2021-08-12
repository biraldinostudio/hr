<?php

namespace App\Http\Livewire\Master\Site;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.master.site.index')->extends('layouts.app')->section('content');
    }
}
