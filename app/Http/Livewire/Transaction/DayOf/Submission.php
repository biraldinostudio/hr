<?php

namespace App\Http\Livewire\Transaction\DayOf;

use Livewire\Component;
use App\Models\DayOf;
use Auth;
class Submission extends Component
{
    //public $dayOfId;
    protected $listeners=[
        'reloadDayOfs'=>'$refresh',
    ];
    /*public function mount($id){
        $dayOfs=DayOf::find($id);
        $this->dayOfId=$dayOfs->id;
        $this->initializedProperties();
    }*/
    //DayOf $dayOf

    public function render(DayOf $dayOfs){
         return view('livewire.transaction.day-of.submission');   
    }

    public function initializedProperties(){

    }
}
