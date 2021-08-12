<?php

namespace App\Http\Livewire\Amenities\PermissionCategory;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.amenities.permission-category.index')->extends('layouts.app')->section('content');
    }
}
