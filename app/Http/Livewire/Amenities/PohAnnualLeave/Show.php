<?php

namespace App\Http\Livewire\Amenities\PohAnnualLeave;

use Livewire\Component;
use App\Models\PohAnnualLeave;
use Livewire\WithPagination;
class Show extends Component
{
    use WithPagination;
    public $sortBy='poh_id';
    public $sortDirection = 'asc';
    public $foo;
    public $search = '';
    public $page = 1;
    public $perPagination = 10;
    public $status;
    protected $paginationTheme = 'bootstrap';
    protected $listeners=[
        'reloadPohAnnualLeaves'=>'$refresh'
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
        if($this->status==null){
            $qry="1";
        }
        else{
            $qry=$this->status;
        }
       $pohAnnualLeaves=PohAnnualLeave::query()->select('id','site_id','poh_id','day_of','active','created_at')
            ->whereHas('Poh', function ($q) {
                $q->where(function($query) {
                    $query->where('name','like','%'.trim($this->search).'%');
                });
            })           
        ->where('active',$qry)
         ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
        return view('livewire.amenities.poh-annual-leave.show',compact('pohAnnualLeaves'));
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
