<?php

namespace App\Http\Livewire\Master\Site;

use Livewire\Component;
use App\Models\Site;
use Livewire\WithPagination;
class Show extends Component
{
    use WithPagination;
    public $sortBy='name';
    public $sortDirection = 'asc';
    public $foo;
    public $search = '';
    public $page = 1;
    public $perPagination = 10;
    public $status;
    protected $paginationTheme = 'bootstrap';
    protected $listeners=[
        'reloadSites'=>'$refresh'
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
       $sites=Site::query()->select('id','code','name','active','created_at')
        ->where('name','like','%'.trim($this->search).'%')
            ->where('active',$qry)
         ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
        return view('livewire.master.site.show',compact('sites'));
    }

    public function sortBy($field){
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';
        $this->sortBy = $field;
    }

    public function reverseSort(){
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }
}
