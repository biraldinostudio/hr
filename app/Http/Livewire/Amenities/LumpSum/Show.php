<?php

namespace App\Http\Livewire\Amenities\LumpSum;

use Livewire\Component;
use App\Models\Lumpsum;
use App\Models\Position;
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
        'reloadLumpSums'=>'$refresh'
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
       $lumpsums=Lumpsum::query()->select('id','site_id','poh_id','position_id','idr','idr_staff','active','created_at')
            ->whereHas('Position', function ($q) {
                $q->where(function($query) {
                    $query->where('name','like','%'.trim($this->search).'%');
                });
            })           
        ->where('active',$qry)
         ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
        return view('livewire.amenities.lump-sum.show',compact('lumpsums'));
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
