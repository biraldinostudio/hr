<?php

namespace App\Http\Livewire\Transaction\DayOf;

use Livewire\Component;
use App\Models\DayOf;
use App\Models\DayOfDestination;
use App\Models\AnnualLeave;
use App\Models\AnnualLeaveCounter;
use App\Models\BigLeave;
use App\Models\BigLeaveClaim;
use App\Models\BigLeaveCounter;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
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

    public $dayOfId;
    public $employeeId;
    public $site;
    public $nrp;
    public $name;
    public $number;

    public $deleteMode = false;
    protected $paginationTheme = 'bootstrap';
    protected $listeners=[
        'reloadDayOfs'=>'$refresh',
    ];

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount(){
        $this->initializedProperties();
    }

    public function updatingSearch(){
        $this->resetPage();
        
    }

    public function showModalDelete(DayOf $dayOfs)
    {
        $this->deleteMode = true;
        $this->dayOfId=$dayOfs->id;
        $this->employeeId=$dayOfs->user_id;
        $this->site=$dayOfs->site->name;
        $this->nrp=$dayOfs->user->nrp;
        $this->name=$dayOfs->user->name;
        $this->number=trim($dayOfs->number);
    }

    public function render(){
        $this->emit('resetSelect2');
        if($this->status==null){
            $qry="1";
        }
        else{
            $qry=$this->status;
        }
        $dayofs=DayOf::query()->select('id','user_id','site_id','poh_id','start','end','in','travel_from_go','travel_to_go','travel_from_back','travel_to_back','head_approv','sm_approv','hrd_approv','approv','update_count','active','created_at')
            ->where('site_id','like','%'.trim($this->search).'%')
            ->where('active',$qry)
            ->where('user_id',Auth::user()->id)
            ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
         return view('livewire.transaction.day-of.show-my',compact('dayofs'));   
    }

    public function deleteDayOf(){
        DB::beginTransaction();
        try{
            DayOf::whereId($this->dayOfId)->where('approv','0')->delete();
            DayOfDestination::where('day_of_id',$this->dayOfId)->delete();
            $annualLeaves =AnnualLeave::where('day_of_id',$this->dayOfId)->first();
            if($annualLeaves){
             if($annualLeaves->start!='' or $annualLeaves->start!=null){
                    $annualLeaveCounters = AnnualLeaveCounter::where('user_id',$this->employeeId)->where('less','>',0)->latest()->first();
                    $annualLeaveCounters->delete();
                    AnnualLeave::where('day_of_id',$this->dayOfId)->where('id',$annualLeaves->id)->delete();
                }
            }
            $bigLeaves =BigLeave::where('day_of_id',$this->dayOfId)->first();
            if($bigLeaves){
             if($bigLeaves->start!='' or $bigLeaves->start!=null){
                    $bigLeaveCounters = BigLeaveCounter::where('user_id',$this->employeeId)->where('less','>',0)->latest()->first();
                    $bigLeaveCounters->delete();

                    $bigLeaveClaims = BigLeaveClaim::where('user_id',$this->employeeId)->where('big_leave_id',$bigLeaves->id)->latest()->first();
                    $bigLeaveClaims->delete();
                    BigLeave::where('day_of_id',$this->dayOfId)->where('id',$bigLeaves->id)->delete();
                }
            }
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Proses berhasil!'
            ]);
            $this->deleteMode = false;
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadDayOfs');
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

    public function submission($id){
        $dayOfs=DayOf::find($id);
        return view('livewire.transaction.day-of.submission',compact('dayOfs'));
    }

    private function initializedProperties(){
        $this->dayOfId=null;
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
