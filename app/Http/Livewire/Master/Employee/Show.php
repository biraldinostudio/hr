<?php

namespace App\Http\Livewire\Master\Employee;

use Livewire\Component;
use App\Models\User;
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
        'reloadEmployees'=>'$refresh'
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
        $search=$this->search;
        $employees=User::query()->select('id','site_id','poh_id','position_id','nrp','ktp','name','level','staff','active','created_at')
        //->where('name','LIKE','%'.$this->search.'%')
        ->where(function($q) use($search){
            $q->where('nrp','LIKE', '%'.$search.'%')
            ->orWhere('nrp','=',$search)
            ->orWhere('name','LIKE', '%'.$search.'%')
            ->orWhere('name','=',$search);
        })

            ->where('active',$qry)
         ->orderBy($this->sortBy,$this->sortDirection)->where('employee','1')->whereIn('level',['employee','hrd_admin','hrd_head','department_head','site_manager'])->paginate($this->perPagination);
        return view('livewire.master.employee.show',compact('employees'));
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
