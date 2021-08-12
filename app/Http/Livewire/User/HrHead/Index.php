<?php

namespace App\Http\Livewire\User\HrHead;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.user.hr-head.index')->extends('layouts.app')->section('content');
    }
}
