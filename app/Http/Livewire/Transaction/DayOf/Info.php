<?php

namespace App\Http\Livewire\Transaction\DayOf;

use Livewire\Component;

class Info extends Component
{
    
    public $postId;

    protected $listeners = [
        'getPostId','cancel',
    ];

    public function getPostId($postId)
    {
        $this->postId = $postId;
    }

    public function render()
    {
        return view('livewire.transaction.day-of.info');
    } 
    
    public function cancelInfoModal(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }

}
