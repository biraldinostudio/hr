<?php

namespace App\Http\Livewire\User\Employee;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.user.employee.index')->extends('layouts.app')->section('content');
    }
}
