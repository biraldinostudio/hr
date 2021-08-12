<?php

namespace App\Http\Livewire\Transaction\Invoice\BigLeave;

use App\Models\BigLeave;
use App\Models\BigLeaveClaim;
use App\Models\BigLeaveCounter;
use App\Models\PohBigLeave;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    public $employeeId;
   
    public $site;
    public $poh;

    public $siteName;
    public $pohName;

    public $bigLeaveStartDate;
    public $bigLeaveEndDate;

    public $addDay=1;
    public $standartDayBigLeave;

    public $workDay;
    public $bigLeaveStandartDay;
    public $bigLeaveStandartSite;
    public $bigLeaveStandartPoh;
    public $bigLeaveStandartMax;
    public $latestBigLeaveLess;
    public $latestBigLeaveYearLess;

    public $latestDayOfLessBefore;

    public $numberBigLeaveClaim;

    public $latestDayOfIn;

    public $description;

    public $workDayFirst;
    protected $listeners = [
        'createInvBigLeave'=>'showModal',
         'selectBigLeaveStartDate'=>'getSelectBigLeaveStartDate',
         'selectBigLeaveEndDate'=>'getSelectBigLeaveEndDate'
     ];

    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'bigLeaveStartDate.after_or_equal'=>':attribute harus sama atau lebih dari tanggal hari ini',
        'bigLeaveEndDate.after'=>':attribute harus lebih dari tanggal mulai cuti besar'
    ];

     protected $validationAttributes = [
        'bigLeaveStartDate'=>'Tgl mulai cuti besar',
        'bigLeaveEndDate'=>'Tgl akhir cuti besar',
        'description'=>'Keterangan tambahan'
    ];

    public function mount(){
        $this->initializedProperties();
    }

        //Real time validate
        public function updated($property, $value){
            if(trim($value)){
                $this->validateOnly($property);
            }else{
                $this->resetErrorBag($property);
            }
        }

    public function showModal(User $users){
        $dateNows=Carbon::now();
        $years= $dateNows->year;
        $months= date('m',strtotime($dateNows));   
        $yearMonths=date('y',strtotime($years)).'/'.$months;
        $this->employeeId=$users->id;

        $this->site=$users->site->id;
        $this->poh=$users->poh->id;
        $this->siteName=$users->site->name;
        $this->pohName=$users->poh->name;

        $pohBigLeaves=PohBigLeave::where('site_id',$users->site_id)->where('poh_id',$users->poh_id)->first();
        if($pohBigLeaves!='' or $pohBigLeaves!=null){
            $this->standartDayBigLeave=$pohBigLeaves->day_of;
        }else{
            $this->standartDayBigLeave=null;
        }

        $latestBigLeaveCounters=BigLeaveCounter::where('user_id',$users->id)->whereYear('last_date', $years)->latest()->first();
        $joinDates=User::select('join_date')->where('id',$users->id)->first(); 
        $planDateReps= str_replace('/', '-', date('Y-m-d'));
        $this->workDayFirst=CountDay($planDateReps,$joinDates->join_date);

        if($latestBigLeaveCounters!='' or $latestBigLeaveCounters!=null){
            $this->latestDayOf=$latestBigLeaveCounters->first_start;
            $this->latestDayOfStandart=$latestBigLeaveCounters->standart;
            $this->latestDayOfShould=$latestBigLeaveCounters->should;
            $this->latestDayOfLess=$latestBigLeaveCounters->less;
            $this->latestDayOfLessBefore=$latestBigLeaveCounters->less_before;
            $this->latestDayOfIn=$latestBigLeaveCounters->last_date;

            $latestLastDateReps= str_replace('/', '-',$latestBigLeaveCounters->last_date);
            $onSiteDayNows=CountDay($planDateReps,$latestLastDateReps);
            
            $this->workDay=$onSiteDayNows;
        }else{
            $this->workDay= $this->workDayFirst;
            $this->latestDayOfLess=0;
            $this->latestDayOfIn=$users->join_date;
            $this->latestDayOfLessBefore=0;
        }
        //Bagian nomor dokumen
        $countBigLeaveChecks=BigLeaveClaim::where('site_id',$users->site->id)->whereMonth('created_at',$months)->whereYear('created_at', $years)->count();
        if($countBigLeaveChecks==0){
            $orders='1001';
            $this->numberBigLeaveClaim='RML-'.$users->site->code.'/'.'INV/'.$yearMonths.'/'.$orders;
        }else{
            $getOrderBigLeaveClaims=BigLeaveClaim::where('site_id',$users->site->id)->whereMonth('created_at',$months)->whereYear('created_at', $years)->latest()->first();
            $orderBigLeaveClaims=(int)substr( $getOrderBigLeaveClaims->number,-4) + 1;
            $this->numberBigLeaveClaim='RML-'.$users->site->code.'/'.'INV/'.$yearMonths.'/'.$orderBigLeaveClaims;
        }
        $this->emit('showModal','createModal');
    }
    
    public function render()
    {
        return view('livewire.transaction.invoice.big-leave.create');
    }

    public function store(){
        //dd($this->bigLeaveStartDate);
        $this->validate();
        $bigLeaveStartDateRep= str_replace('/', '-', $this->bigLeaveStartDate);
        $bigLeaveEndDateRep= str_replace('/', '-', $this->bigLeaveEndDate);      
        $bigLeaveCalculate=CountDay($bigLeaveStartDateRep,$bigLeaveEndDateRep);    
        if($this->workDayFirst<1825){
            $bigLeaveStandartDayRecords=0;
            $latestBigLeaveLessRecords=0;
            $bigLeaveYearChecks='';
            $bigLeaveStartDateChecks='';
            $bigLeaveEndDateChecks='';
            $bigLeaveChecks='';
        }else{
            $bigLeaveYearChecks=date('Y', strtotime($bigLeaveStartDateRep));
            $bigLeaveStartDateChecks=date('Y-m-d', strtotime($bigLeaveStartDateRep));
            $bigLeaveEndDateChecks=date('Y-m-d', strtotime($bigLeaveEndDateRep));
            $bigLeaveChecks=$bigLeaveCalculate + $this->addDay;
            $bigLeaveStandartDayRecords=$this->bigLeaveStandartDay;
            $latestBigLeaveLessRecords=$this->latestBigLeaveLess;
        }

        if($this->bigLeaveStartDate=='' or $this->bigLeaveStartDate==null){
            $bigLeaveStartDateChecks=null;
            $bigLeaveEndDateChecks=null;
            $bigLeaveChecks=0;
        }  
        
        if($this->bigLeaveEndDate=='' or $this->bigLeaveEndDate==null){
            $bigLeaveStartDateChecks=null;
            $bigLeaveEndDateChecks=null;
            $bigLeaveChecks=0;
        }

        /*$dateNows=Carbon::now();
        $years= $dateNows->year;
        $months= date('m',strtotime($dateNows));   
        $countBigLeaveCounters=BigLeaveCounter::where('user_id',Auth::user()->id)->whereYear('year', $years)->count();
*/
       DB::beginTransaction();
        try{
            $bigLeaves = new BigLeave();
            $bigLeaves->user_id = $this->employeeId;
            $bigLeaves->site_id = $this->site;
            $bigLeaves->poh_id = $this->poh;
            $bigLeaves->day_of_id = null;
            $bigLeaves->year = $bigLeaveYearChecks;
            $bigLeaves->start = $bigLeaveStartDateChecks;
            $bigLeaves->end = $bigLeaveEndDateChecks;
            $bigLeaves->sum=$bigLeaveCalculate + $this->addDay;
            $bigLeaves->standart=$bigLeaveStandartDayRecords;
            $bigLeaves->should=$bigLeaveStandartDayRecords + $latestBigLeaveLessRecords;
            $bigLeaves->less=($bigLeaveStandartDayRecords +  $latestBigLeaveLessRecords)-($bigLeaveChecks);
            $bigLeaves->less_before=$this->latestDayOfLessBefore;
            $bigLeaves->description=$this->description;
            $bigLeaves->take='0';
            $bigLeaves->active = '1';
            $bigLeaves->save();

            $bigLeaveCounters = new bigLeaveCounter();
            $bigLeaveCounters->user_id = $this->employeeId;
            $bigLeaveCounters->site_id = $this->site;
            $bigLeaveCounters->year = $bigLeaveYearChecks;
            $bigLeaveCounters->day=$bigLeaveCalculate + $this->addDay;
            $bigLeaveCounters->standart=$bigLeaveStandartDayRecords;
            $bigLeaveCounters->should=$bigLeaveStandartDayRecords + $latestBigLeaveLessRecords;
            $bigLeaveCounters->less=($bigLeaveStandartDayRecords +  $latestBigLeaveLessRecords)-($bigLeaveChecks);
            $bigLeaveCounters->less_before=$this->latestDayOfLessBefore;
            $bigLeaveCounters->first_date = $bigLeaveStartDateChecks;
            $bigLeaveCounters->last_date = $bigLeaveEndDateChecks;
            $bigLeaveCounters->save();
            
            $bigLeaveClaims = new BigLeaveClaim();
            $bigLeaveClaims->big_leave_id = $bigLeaves->id;
            $bigLeaveClaims->user_id = $this->employeeId;
            $bigLeaveClaims->site_id = $this->site;
            $bigLeaveClaims->number=$this->numberBigLeaveClaim;
            $bigLeaveClaims->year=$bigLeaveYearChecks;
            $bigLeaveClaims->idr=null;
            $bigLeaveClaims->multiplier_salary='2';
            $bigLeaveClaims->head_approv='0';
            $bigLeaveClaims->hrd_approv='0';
            $bigLeaveClaims->sm_approv='0';
            $bigLeaveClaims->approv='0';
            $bigLeaveClaims->paid='0';
            $bigLeaveClaims->active = '1';
            $bigLeaveClaims->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','createModal');
            $this->emit('reloadBigLeaveClaimReference');
        }catch(\Throwable $th){
            DB::rollBack();
          $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Create Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
        }
        DB::commit();
    }

    public function getSelectBigLeaveStartDate($date) {
        $this->bigLeaveStartDate=$date;
        if($this->bigLeaveStartDate!='' or $this->bigLeaveStartDate!=null){
            $this->bigLeaveEndDate =   date('d/m/Y', strtotime(str_replace('/', '-', $this->bigLeaveStartDate). ' + '.$this->standartDayBigLeave.' days - '.$this->addDay.' days'));
        }else{
            $this->bigLeaveEndDate=$this->bigLeaveStartDate;
        }
    }
    public function getSelectBigLeaveEndDate($date) {
        $this->bigLeaveEndDate=$date;
        if($this->bigLeaveEndDate=='' or $this->bigLeaveEndDate==null){
            $this->bigLeaveStartDate=$this->bigLeaveEndDate;
        }else{
            $this->bigLeaveStartDate=$this->bigLeaveStartDate;
        }
    }
    private function initializedProperties(){
        $this->site=null;
        $this->poh=null;

        $this->bigLeaveStartDate=null;
        $this->bigLeaveEndDate=null;

        $this->workDay=null;
        $this->bigLeaveStandartDay=null;
        $this->bigLeaveStandartSite=null;
        $this->bigLeaveStandartPoh=null;
        $this->bigLeaveStandartMax=null;
        $this->latestBigLeaveLess=null;
        $this->latestBigLeaveYearLess=null;
        $this->latestDayOfLessBefore=null;
        $this->description=null;
        $this->numberBigLeaveClaim=null;

        $this->workDayFirst=null;
    }
    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }

    public function rules(){
        return[
            'bigLeaveStartDate' => 'required|date_format:"d/m/Y"|after_or_equal:'.date("d/m/Y"),
            'bigLeaveEndDate'=>'required|date_format:"d/m/Y"|after:bigLeaveStartDate',
            'description'=>'required|min:10|max:500'      
        ];
    }

}
