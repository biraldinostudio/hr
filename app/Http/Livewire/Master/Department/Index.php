<?php

namespace App\Http\Livewire\Master\Department;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.master.department.index')->extends('layouts.app')->section('content');
    }
}
