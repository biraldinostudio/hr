<?php

namespace App\Http\Livewire\Transaction\Assignment;

use App\Models\Assignment;
use App\Models\AssignmentDestination;
use App\Models\ApprovalRecord;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Auth;
class ShowMy extends Component
{
    use WithPagination;
    public $sortBy='created_at';
    public $sortDirection = 'asc';
    public $foo;
    public $search = '';
    public $page = 1;
    public $perPagination = 10;
    public $status;

    public $assignmentId;
    public $employeeId;
    public $site;
    public $nrp;
    public $name;
    public $number;

    public $deleteMode = false;

    protected $paginationTheme = 'bootstrap';
    protected $listeners=[
        'reloadAssignments'=>'$refresh',
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
        $assignments=Assignment::query()->select('id','user_id','site_id','start_date','end_date','in_date','sum_day','description','location'
            ,'lodging_cost','transportation_cost','meal_cost','other_cost'
            ,'lodging_day','transportation_day','meal_day','other_day'
            ,'head_approv','sm_approv','hrd_approv','approv','active','created_at')
            ->where('site_id','like','%'.trim($this->search).'%')
            ->where('active',$qry)
            ->where('user_id',Auth::user()->id)
            ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
         return view('livewire.transaction.assignment.show-my',compact('assignments'));   
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

    public function submission($id){
        $assignments=Assignment::find($id);
        return view('livewire.transaction.assignment.show-my',compact('assignments'));
    }

    public function showModalDelete(Assignment $assignments)
    {
        $this->deleteMode = true;
        $this->assignmentId=$assignments->id;
        $this->employeeId=$assignments->user_id;
        $this->site=$assignments->site->name;
        $this->nrp=$assignments->user->nrp;
        $this->name=$assignments->user->name;
        $this->number=trim($assignments->number);
       
    }

    public function deleteAssignment(){
        DB::beginTransaction();
        try{
            AssignmentDestination::where('assignment_id',$this->assignmentId)->delete();
            ApprovalRecord::where('doc',$this->assignmentId)->where('type','dinas')->delete();
            Assignment::whereId($this->assignmentId)->where('approv','0')->delete();
            
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Proses berhasil!'
            ]);

            $this->deleteMode = false;
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadAssignments');
            $this->initializedProperties();            
        }catch(\Throwable $th){
            DB::rollBack();
            $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Hapus Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
        }
        DB::commit();
    }

    private function initializedProperties(){
        $this->assignmentId=null;
        $this->employeeId=null;
        $this->site=null;
        $this->nrp=null;
        $this->name=null;
        $this->number=null;
    }

    public function cancel()
    {
        $this->deleteMode = false;
        $this->resetErrorBag();
        $this->initializedProperties();
        $this->emit('closeModal','deleteModal');
    }

}
 