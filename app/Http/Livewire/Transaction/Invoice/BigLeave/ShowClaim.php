<?php

namespace App\Http\Livewire\Transaction\Invoice\BigLeave;

use Livewire\Component;
use App\Models\User;
use App\Models\BigLeave;
use App\Models\BigLeaveClaim;
use Livewire\WithPagination;
class ShowClaim extends Component
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
        'reloadBigLeaveClaim'=>'$refresh'
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
        $claims=BigLeaveClaim::query()->select('big_leave_claims.id','big_leave_claims.number','big_leave_claims.year','big_leave_claims.idr'
            ,'big_leave_claims.multiplier_salary','big_leave_claims.paid','big_leave_claims.active','big_leave_claims.created_at'
            ,'a.nrp','a.name','a.position_id','b.name as site','d.name as position','e.name as department'
                )                
                ->join('users as a', 'a.id', '=', 'big_leave_claims.user_id')
                ->join('sites as b', 'big_leave_claims.site_id', '=', 'b.id')
                ->join('big_leaves as c', 'big_leave_claims.big_leave_id', '=', 'c.id')
                ->join('positions as d', 'a.position_id', '=', 'd.id')
                ->join('departments as e', 'd.department_id', '=', 'e.id')
                ->orWhere(function($query)  {
                    $query->where('a.name','like','%'.trim($this->search).'%')
                          ->orWhere('a.nrp','like','%'.trim($this->search).'%')
                          ->orWhere('b.name','like','%'.trim($this->search).'%')
                          ->orWhere('d.name','like','%'.trim($this->search).'%')
                          ->orWhere('e.name','like','%'.trim($this->search).'%')
                          ;
                })
               // ->SDayOfWhere($qry,$siteCheck,$departmentCheck)
                ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
                return view('livewire.transaction.invoice.big-leave.show-claim',compact('claims'));
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
