<?php

namespace App\Http\Livewire\User\MyAccount;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.user.my-account.index')->extends('layouts.app')->section('content');
    }
}
