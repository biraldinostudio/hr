<?php

namespace App\Http\Livewire\Amenities\PohDayOf;

use Livewire\Component;
use App\Models\PohDayOf;
use Livewire\WithPagination;
class Show extends Component
{
    use WithPagination;
    public $sortBy='created_at';
    public $sortDirection = 'desc';
    public $foo;
    public $search = '';
    public $page = 1;
    public $perPagination = 10;
    public $status;
    protected $paginationTheme = 'bootstrap';
    protected $listeners=[
        'reloadPohDayOfs'=>'$refresh'
    ];

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch(){
        $this->resetPage();
        
    }

    public function render(){
        $this->emit('resetSelect2');
        if($this->status==null){
            $qry="1";
        }
        else{
            $qry=$this->status;
        }
       $pohdayofs=PohDayOf::query()->select('id','site_id','poh_id','day_of','travel_day','travel_day_ticket','lumpsum_facilities','active','created_at')
       //->with('Poh')
        ->whereHas('Poh', function($q){
            $q->where('name','like','%'.trim($this->search).'%');
        })     
        ->where('active',$qry)
         ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
        return view('livewire.amenities.poh-day-of.show',compact('pohdayofs'));
    }

    public function sortBy($field){
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
        /*if($this->sortDirection=='asc'){
            $this->sortDirection='desc';
        }else{
            $this->sortDirection='asc';
        }
        return $this->sortBy = $field; */
    }

    public function reverseSort(){
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }
}
