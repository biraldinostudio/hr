<?php

namespace App\Http\Livewire\User\HrAdmin;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.user.hr-admin.index')->extends('layouts.app')->section('content');
    }
}
