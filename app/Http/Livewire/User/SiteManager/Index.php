<?php

namespace App\Http\Livewire\User\SiteManager;

use Livewire\Component;

class Index extends Component
{   
    public function render()
    {
        return view('livewire.user.site-manager.index')->extends('layouts.app')->section('content');
    }
}
