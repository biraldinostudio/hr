<?php

namespace App\Http\Livewire\Transaction\Invoice\BigLeave;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.transaction.invoice.big-leave.index')->extends('layouts.app')->section('content');
    }
}
