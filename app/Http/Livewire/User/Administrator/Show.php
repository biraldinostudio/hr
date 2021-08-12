<?php

namespace App\Http\Livewire\User\Administrator;

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
        'reloadAdministrators'=>'$refresh'
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
        $employees=User::query()->select('id','site_id','position_id','nrp','ktp','name','level','active','created_at')
        ->where('name','LIKE','%'.$this->search.'%')
            ->where('active',$qry)
            ->where('level','administrator')
             ->where('id','!=',1)
         ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
        return view('livewire.user.administrator.show',compact('employees'));
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
