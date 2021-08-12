<?php

namespace App\Http\Livewire\User\DepartmentHead;

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
        'reloadDepartmentHeads'=>'$refresh'
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
         $employees=User::query()->select('users.id','users.site_id','users.position_id','b.department_id','a.name as site','b.name as position','c.name as department','users.nrp','users.name','users.level','users.active','users.created_at')
            ->join('sites as a', 'a.id', '=', 'users.site_id')
            ->join('positions as b', 'b.id', '=', 'users.position_id')
            ->join('departments as c', 'c.id', '=', 'b.department_id')
            ->where('users.name','LIKE','%'.$this->search.'%')
            ->where('users.active',$qry)
            ->where('users.level','department_head')
             ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
        return view('livewire.user.department-head.show',compact('employees'));
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
