<?php

namespace App\Http\Livewire\User\DepartmentHead;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.user.department-head.index')->extends('layouts.app')->section('content');
    }
}
