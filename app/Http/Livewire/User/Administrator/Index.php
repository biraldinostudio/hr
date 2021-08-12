<?php

namespace App\Http\Livewire\User\Administrator;

use Livewire\Component;

class Index extends Component
{   
    public function render()
    {
        return view('livewire.user.administrator.index')->extends('layouts.app')->section('content');
    }
}
