<?php

namespace App\Http\Livewire\Master\Employee;

use Livewire\Component;

class Index extends Component
{
    //public $showShowx = false;
    //public $showCreate = false;
    public function render()
    {
        return view('livewire.master.employee.index')->extends('layouts.app')->section('content');
    }
}
