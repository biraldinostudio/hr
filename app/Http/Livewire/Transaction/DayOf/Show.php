<?php

namespace App\Http\Livewire\Transaction\DayOf;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\AnnualLeave;
use App\Models\PohAnnualLeave;
use App\Models\ApprovalRecord;
use App\Models\PohBigLeave;
use App\Models\BigLeave;
use App\Models\BigLeaveClaim;
use App\Models\DayOf;
use App\Models\User;
use App\Models\DayOfDestination;
use Livewire\WithPagination;
use Auth;
use PDF;
use Dompdf\Dompdf;
class Show extends Component
{
    use WithPagination;
    public $sortBy='created_at';
    public $sortDirection = 'asc';
    public $foo;
    public $search = '';
    public $page = 1;
    public $perPagination = 10;
    public $status;


    public $number;
    public $dayOfId;
    public $employee;
    public $employeeId;
    public $nrp;
    public $site;
    public $department;
    public $position;
    public $planDate;
    public $startDate;
    public $endDate;
    public $inDate;
    public $inDateBefore;
    public $workDay;
    public $dayOfSum;
    public $dayOfTotal;
    public $dayOfGrandTotal;
    public $dayOfStandart;
    public $dayOfShould;
    public $dayOfLess;
    public $travelDateFromGo;
    public $travelDateFromBack;
    public $ticketDateFromGo;	
    public $ticketDateFromBack;
    public $ticketTimeGo;
    public $ticketTimeBack;
    public $travelDayGo;
    public $travelDayBack;
    public $travelFromGo;

    public $annualLeaveLess;
    public $annualLeaveStandart;
    public $annualLeaveSum;
    public $annualLeaveStartDate;
    public $annualLeaveEndDate;
    public $annualLeaveStandartDay;

    public $bigLeaveLess;
    public $bigLeaveStandartDay;
    public $bigLeaveStartDate='';
    public $bigLeaveEndDate='';

    public $expireCheck;

    public $addDayThree=3;
    public $addDay=1;

    public $onSiteDate;
    public $onSiteDayCalculate;
    public $bigLeaveShouldDay;
    public $bigLeaveStandartMax;

    public $dayOfStandartDayTravel;
    public $dayOfStandartDayTicket;
    public $dayOfStandartSite;
    public $dayOfStandartPoh;  

    public $description;

    public $updateTicketDateFromBack;

    public $reason;

    public $approvMode = false;
    public $notApprovMode = false;

    protected $paginationTheme = 'bootstrap';
    protected $listeners=[
        'reloadDayOfs'=>'$refresh'
    ];

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'reason' => 'required|min:10|max:500|',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
    ];

    protected $validationAttributes = [
        'reason' => 'Alasan tidak menyetujui'
    ];

    public function updatingSearch(){
        $this->resetPage();
        
    }

    public function updated($property, $value){
        
        if(trim($value)){
            $this->validateOnly($property);
        }else{
            $this->resetErrorBag($property);
        }
    }
    
    public function showModalApprov($id){
        $dayOfs=DayOf::find($id);;
        $this->approvMode = true;
        $this->notApprovMode = false;
        $this->emit('closeModal','notApprovModal');
        $this->dayOfId=$dayOfs->id;
        //$this->site=$dayOfs->site->id;
        $this->position=$dayOfs->user->position->name;
        $this->department=$dayOfs->user->position->department->name;
        $this->nrp=$dayOfs->user->nrp;
        $this->employee=$dayOfs->user->name;
        $this->employeeId = $dayOfs->user_id;
        $this->site = $dayOfs->site_id;
        $this->poh = $dayOfs->poh_id;
        $this->number=$dayOfs->number;
        $this->startDate = date('d/m/Y',strtotime($dayOfs->start));
        $this->endDate = date('d/m/Y',strtotime($dayOfs->end));
        $this->inDate = date('d/m/Y',strtotime($dayOfs->in));
        $this->inDateBefore =date('d/m/Y',strtotime($dayOfs->in_before));
        $this->workDay=$dayOfs->work_day;
        $this->dayOfSum=$dayOfs->day_of_sum;
        $this->dayOfTotal=$dayOfs->day_of_total;
        $this->dayOfGrandTotal=$dayOfs->day_of_grandtotal;
        $this->dayOfStandart=$dayOfs->day_of_standart;
        $this->dayOfShould=$dayOfs->day_of_should;
        $this->dayOfLess=$dayOfs->day_of_less;
        $this->travelDateFromGo=date('d/m/Y',strtotime($dayOfs->travel_from_go));
        $this->travelDateFromBack=date('d/m/Y',strtotime($dayOfs->travel_from_back));
        $this->ticketDateFromGo=date('d/m/Y',strtotime($dayOfs->ticket_from_go));	
        $this->ticketDateFromBack=date('d/m/Y',strtotime($dayOfs->ticket_from_back));
        $this->ticketTimeGo=$dayOfs->ticket_time_go;
        $this->ticketTimeBack=$dayOfs->ticket_time_back;
        $this->travelDayGo=$dayOfs->travel_day_go;
        $this->travelDayBack=$dayOfs->travel_day_back;
        $this->description=$dayOfs->description;
        
        $annualLeaves=AnnualLeave::where('day_of_id',$dayOfs->id)->where('active','1')->latest()->first();
        if($annualLeaves){
            $this->annualLeaveStartDate = date('d/m/Y',strtotime($annualLeaves->start));
            $this->annualLeaveEndDate = date('d/m/Y',strtotime($annualLeaves->end));
            $this->annualLeaveSum = $annualLeaves->sum;
            $this->annualLeaveStandart = $annualLeaves->standart;
            $this->annualLeaveLess =$annualLeaves->less;

            if($annualLeaves->end!='' or $annualLeaves->end!=null){
                $this->bigLeaveStartDate =   date('d/m/Y', strtotime(str_replace('/', '-',$annualLeaves->end). ' + '.$this->addDay.' days')); 
            }else{
                $this->bigLeaveStartDate =   date('d/m/Y', strtotime(str_replace('/', '-',$dayOfs->end). ' + '.$this->addDay.' days'));
            }

        }

        $bigLeaves=BigLeave::where('day_of_id',$dayOfs->id)->where('active','1')->latest()->first();
        if($bigLeaves){
            $this->bigLeaveStartDate = date('d/m/Y',strtotime($bigLeaves->start));
            $this->bigLeaveEndDate = date('d/m/Y',strtotime($bigLeaves->end));
            $this->bigLeaveSum = $bigLeaves->sum;
            $this->bigLeaveStandart = $bigLeaves->standart;
            $this->bigLeaveLess =$bigLeaves->less;

            if($bigLeaves->end!='' or $bigLeaves->end!=null){
                $this->bigLeaveStartDate =   date('d/m/Y', strtotime(str_replace('/', '-',$bigLeaves->end). ' + '.$this->addDay.' days')); 
            }else{
                $this->bigLeaveStartDate =   date('d/m/Y', strtotime(str_replace('/', '-',$dayOfs->end). ' + '.$this->addDay.' days'));
            }

        }

        $pohBigLeaves=PohBigLeave::where('site_id', $this->site)->where('poh_id', $this->poh)->where('active','1')->latest()->first();
        if($pohBigLeaves){
            $this->bigLeaveStandartDay=$pohBigLeaves->day_of;
  
        }

        $pohAnnualLeaves=PohAnnualLeave::where('site_id', $this->site)->where('poh_id', $this->poh)->where('active','1')->latest()->first();
        if($pohAnnualLeaves){
            $this->annualLeaveStandartDay=$pohAnnualLeaves->day_of;
        }

        $onSiteDateReps= str_replace('/', '-', $this->onSiteDate);
        $bigLeaveStartDateReps= str_replace('/', '-', $this->bigLeaveStartDate);
        $this->onSiteDayCalculate=CountDay($onSiteDateReps,$bigLeaveStartDateReps);
        
        $dayOfStandarts = User::select('c.day_of as day','c.travel_day as dayTravel','c.travel_day_ticket as dayTicket','a.name as site','b.name as poh')
        ->join('sites as a', 'a.id', '=', 'users.site_id')
        ->join('pohs as b', 'b.id', '=', 'users.poh_id')
        ->leftjoin('poh_day_ofs as c', function ($join) {
            $join->on('c.site_id', '=', 'a.id')
                 ->on('c.poh_id', '=', 'b.id');
            })
        ->where('users.id',$this->employeeId)->first();

        $this->dayOfStandartDay=$dayOfStandarts->day;
        $this->dayOfStandartDayTravel=$dayOfStandarts->dayTravel/2;
        $this->dayOfStandartDayTicket=$dayOfStandarts->dayTicket/2;
        $this->dayOfStandartSite=$dayOfStandarts->site;
        $this->dayOfStandartPoh=$dayOfStandarts->poh;

    }


    public function showModalNotApprov(DayOf $dayOfs)
    {
        $this->notApprovMode = true;
        $this->approvMode = false;
        $this->emit('closeModal','approvModal');
        $this->dayOfId=$dayOfs->id;
        $this->site=$dayOfs->site->name;
        $this->position=$dayOfs->user->position->name;
        $this->department=$dayOfs->user->position->department->name;
        $this->nrp=$dayOfs->user->nrp;
        $this->employee=$dayOfs->user->name;
        $this->travelFromGo=$dayOfs->travel_from_go;
    }

    public function render(){
        $this->emit('resetSelect2');
        if($this->status==null){
            $qry="1";
        }
        else{
            $qry=$this->status;
        } 
        $siteCheck=Auth::user()->site_id;
        $departmentCheck=Auth::user()->position->department->id;
        $dayofs=DayOf::query()->select('day_ofs.id','day_ofs.user_id','day_ofs.site_id','day_ofs.poh_id','day_ofs.start','day_ofs.end','day_ofs.in','day_ofs.travel_from_go','day_ofs.travel_to_go','day_ofs.travel_from_back','day_ofs.travel_to_back','day_ofs.head_approv','day_ofs.sm_approv','day_ofs.hrd_approv','day_ofs.approv','day_ofs.active','day_ofs.created_at'
                ,'a.nrp','a.name','a.position_id','c.name as position','c.department_id','d.name as department','e.name as poh'
                )                
                ->join('users as a', 'a.id', '=', 'day_ofs.user_id')
                ->join('sites as b', 'day_ofs.site_id', '=', 'b.id')
                ->join('positions as c', 'a.position_id', '=', 'c.id')
                ->join('departments as d', 'c.department_id', '=', 'd.id')
                ->join('pohs as e', 'day_ofs.poh_id', '=', 'e.id')
                ->orWhere(function($query)  {
                    $query->where('a.name','like','%'.trim($this->search).'%')
                          ->orWhere('a.nrp','like','%'.trim($this->search).'%')
                          ->orWhere('b.name','like','%'.trim($this->search).'%')
                          ->orWhere('e.name','like','%'.trim($this->search).'%')
                          ;
                })
                 ->SDayOfWhere($qry,$siteCheck,$departmentCheck)
                ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
                 return view('livewire.transaction.day-of.show',compact('dayofs'));
        
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
        $destinationGoTickets=DayOfDestination::select('b.name as from','c.name as to','destination')
            ->join('day_ofs as a', 'a.id', '=', 'day_of_destinations.day_of_id')
            ->join('destinations as b', 'b.id', '=', 'day_of_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'day_of_destinations.to_id')            
            ->where('day_of_id',$dayOfs->id)->where('type','Go')->where('destination','Ticket')->first();
        $destinationBackTickets=DayOfDestination::select('b.name as from','c.name as to','destination')
            ->join('day_ofs as a', 'a.id', '=', 'day_of_destinations.day_of_id')
            ->join('destinations as b', 'b.id', '=', 'day_of_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'day_of_destinations.to_id')            
            ->where('day_of_id',$dayOfs->id)->where('type','Back')->where('destination','Ticket')->first();

        $destinationGoTravels=DayOfDestination::select('b.name as from','c.name as to','destination')
            ->join('day_ofs as a', 'a.id', '=', 'day_of_destinations.day_of_id')
            ->join('destinations as b', 'b.id', '=', 'day_of_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'day_of_destinations.to_id')            
            ->where('day_of_id',$dayOfs->id)->where('type','Go')->where('destination','Travel')->first();
        $destinationBackTravels=DayOfDestination::select('b.name as from','c.name as to','destination')
            ->join('day_ofs as a', 'a.id', '=', 'day_of_destinations.day_of_id')
            ->join('destinations as b', 'b.id', '=', 'day_of_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'day_of_destinations.to_id')            
            ->where('day_of_id',$dayOfs->id)->where('type','Back')->where('destination','Travel')->first();

        $approvalRecords=ApprovalRecord::select('a.head_approv','a.hrd_approv','a.sm_approv','c.level as level_approv','c.nrp','c.name as approver','c.hr_head','approval_records.level as level_order','approval_records.created_at')
            ->leftjoin('day_ofs as a', 'a.id', '=', 'approval_records.doc')
            ->join('users as b', 'b.id', '=', 'a.user_id')  
            ->leftjoin('users as c', 'c.id', '=', 'approval_records.user_id')        
            ->where('approval_records.doc',$dayOfs->id)->where('approval_records.type','cuti')->get();

            $annualLeaves=AnnualLeave::where('day_of_id',$dayOfs->id)->first();
            $bigLeaves=BigLeave:: where('day_of_id',$dayOfs->id)->first();              
          return view('livewire.transaction.day-of.submission',
             [
                'dayOfs'=>$dayOfs,
                'destinationGoTickets'=>$destinationGoTickets,
                'destinationBackTickets'=>$destinationBackTickets,
                'destinationGoTravels'=>$destinationGoTravels,
                'destinationBackTravels'=>$destinationBackTravels,
                'approvalRecords'=>$approvalRecords,
                'annualLeaves'=>$annualLeaves,
                'bigLeaves'=>$bigLeaves
            ]);        
        //return view('livewire.transaction.day-of.submission',compact('dayOfs','destinationGoTickets','destinationBackTickets','destinationGoTravels','destinationBackTravels','approvalRecords'));
    }
    public function print($id){
        $dayOfs=DayOf::find($id);
        $destinationGoTickets=DayOfDestination::select('b.name as from','c.name as to','destination')
            ->join('day_ofs as a', 'a.id', '=', 'day_of_destinations.day_of_id')
            ->join('destinations as b', 'b.id', '=', 'day_of_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'day_of_destinations.to_id')            
            ->where('day_of_id',$dayOfs->id)->where('type','Go')->where('destination','Ticket')->first();
        $destinationBackTickets=DayOfDestination::select('b.name as from','c.name as to','destination')
            ->join('day_ofs as a', 'a.id', '=', 'day_of_destinations.day_of_id')
            ->join('destinations as b', 'b.id', '=', 'day_of_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'day_of_destinations.to_id')            
            ->where('day_of_id',$dayOfs->id)->where('type','Back')->where('destination','Ticket')->first();

        $destinationGoTravels=DayOfDestination::select('b.name as from','c.name as to','destination')
            ->join('day_ofs as a', 'a.id', '=', 'day_of_destinations.day_of_id')
            ->join('destinations as b', 'b.id', '=', 'day_of_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'day_of_destinations.to_id')            
            ->where('day_of_id',$dayOfs->id)->where('type','Go')->where('destination','Travel')->first();
        $destinationBackTravels=DayOfDestination::select('b.name as from','c.name as to','destination')
            ->join('day_ofs as a', 'a.id', '=', 'day_of_destinations.day_of_id')
            ->join('destinations as b', 'b.id', '=', 'day_of_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'day_of_destinations.to_id')            
            ->where('day_of_id',$dayOfs->id)->where('type','Back')->where('destination','Travel')->first();

        $approvalRecords=ApprovalRecord::select('a.head_approv','a.hrd_approv','a.sm_approv','c.level as level_approv','b.level as employeeLevel','c.nrp','c.name as approver','c.hr_head','approval_records.level as level_order','approval_records.created_at')
            ->leftjoin('day_ofs as a', 'a.id', '=', 'approval_records.doc')
            ->join('users as b', 'b.id', '=', 'a.user_id')  
            ->leftjoin('users as c', 'c.id', '=', 'approval_records.user_id')        
            ->where('approval_records.doc',$dayOfs->id)->where('approval_records.type','cuti')->get();

            $annualLeaves=AnnualLeave::where('day_of_id',$dayOfs->id)->first();
            $bigLeaves=BigLeave:: where('day_of_id',$dayOfs->id)->first();             
          return view('livewire.transaction.day-of.print',
             [
                'dayOfs'=>$dayOfs,
                'destinationGoTickets'=>$destinationGoTickets,
                'destinationBackTickets'=>$destinationBackTickets,
                'destinationGoTravels'=>$destinationGoTravels,
                'destinationBackTravels'=>$destinationBackTravels,
                'approvalRecords'=>$approvalRecords,
                'annualLeaves'=>$annualLeaves,
                'bigLeaves'=>$bigLeaves
            ]);
        }

        public function approvStore(){
            $checkStaff=DayOf::whereId($this->dayOfId)->first();
            $annualLeaveChecks=AnnualLeave::where('day_of_id',$this->dayOfId)->count();
            $bigLeaveChecks=BigLeave::where('day_of_id',$this->dayOfId)->count();
            DB::beginTransaction();
            try{
                if($checkStaff->user->level=='department_head'){
                    if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='1'){
                        $approvs = DayOf::whereId($this->dayOfId)->first();
                        $approvs->hrd_approv='1';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->level='1';
                        $approvRecords->type='cuti';
                        $approvRecords->active='1';
                        $approvRecords->save();

                        if($bigLeaveChecks!=0){
                            $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                            $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                            $bigLeaveClaims->hrd_approv='1';
                            $bigLeaveClaims->save();
                        }
                    }
    
                    if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                        $approvs = DayOf::whereId($this->dayOfId)->first();
                        $approvs->sm_approv='1';
                        $approvs->approv='1';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->level='2';
                        $approvRecords->type='cuti';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($annualLeaveChecks!=0){
                            $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                            $annualLeaves->approv='1';
                            $annualLeaves->save();
                        }
    
                        if($bigLeaveChecks!=0){
                            $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                            $bigLeaves->approv='1';
                            $bigLeaves->save();

                            $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                            $bigLeaveClaims->sm_approv='1';
                            $bigLeaveClaims->approv='1';
                            $bigLeaveClaims->save();
                        }
                    }
                }
                if($checkStaff->user->level=='sm_manager'){
                    if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='1'){
                        $approvs = DayOf::whereId($this->dayOfId)->first();
                        $approvs->hrd_approv='1';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->level='1';
                        $approvRecords->type='cuti';
                        $approvRecords->active='1';
                        $approvRecords->save();

                        if($bigLeaveChecks!=0){
                            $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                            $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                            $bigLeaveClaims->hrd_approv='1';
                            $bigLeaveClaims->save();
                        }
                    }                
                    if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                        $approvs = DayOf::whereId($this->dayOfId)->first();
                        $approvs->sm_approv='1';
                        $approvs->approv='1';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->level='2';
                        $approvRecords->type='cuti';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($annualLeaveChecks!=0){
                            $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                            $annualLeaves->approv='1';
                            $annualLeaves->save();
                        }
    
                        if($bigLeaveChecks!=0){
                            $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                            $bigLeaves->approv='1';
                            $bigLeaves->save();

                            $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                            $bigLeaveClaims->sm_approv='1';
                            $bigLeaveClaims->approv='1';
                            $bigLeaveClaims->save();
                        }
                    }
                }
                if($checkStaff->user->level=='employee' or $checkStaff->user->level=='hrd_admin'){
                    if($checkStaff->user->staff=='0'){
                        if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='0'){
                            $approvs = DayOf::whereId($this->dayOfId)->first();
                            $approvs->head_approv='1';
                            $approvs->save();
            
                            $approvRecords = new ApprovalRecord();
                            $approvRecords->doc=$approvs->id;
                            $approvRecords->user_id=Auth::user()->id;
                            $approvRecords->level='1';
                            $approvRecords->type='cuti';
                            $approvRecords->active='1';
                            $approvRecords->save();

                            if($bigLeaveChecks!=0){
                                $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                                $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                                $bigLeaveClaims->head_approv='1';
                                $bigLeaveClaims->save();
                            }
                        }
            
                        if(Auth::user()->hr_head=='1'){
                            $approvs = DayOf::whereId($this->dayOfId)->first();
                            $approvs->hrd_approv='1';
                            $approvs->approv='1';
                            $approvs->save();
            
                            $approvRecords = new ApprovalRecord();
                            $approvRecords->doc=$approvs->id;
                            $approvRecords->user_id=Auth::user()->id;
                            $approvRecords->level='2';
                            $approvRecords->type='cuti';
                            $approvRecords->active='1';
                            $approvRecords->save();
                            if($annualLeaveChecks!=0){
                                $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                                $annualLeaves->approv='1';
                                $annualLeaves->save();
                            }
    
                            if($bigLeaveChecks!=0){
                                $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                                $bigLeaves->approv='1';
                                $bigLeaves->save();

                                $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                                $bigLeaveClaims->hrd_approv='1';
                                $bigLeaveClaims->approv='1';
                                $bigLeaveClaims->save();
                            }
                        }
                    }else{
                        if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='0'){
                            $approvs = DayOf::whereId($this->dayOfId)->first();
                            $approvs->head_approv='1';
                            $approvs->save();
            
                            $approvRecords = new ApprovalRecord();
                            $approvRecords->doc=$approvs->id;
                            $approvRecords->user_id=Auth::user()->id;
                            $approvRecords->level='1';
                            $approvRecords->type='cuti';
                            $approvRecords->active='1';
                            $approvRecords->save(); 

                            if($bigLeaveChecks!=0){
                                $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                                $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                                $bigLeaveClaims->head_approv='1';
                                $bigLeaveClaims->save();
                            }
                        }
            
                        if(Auth::user()->hr_head=='1'){
                            $approvs = DayOf::whereId($this->dayOfId)->first();
                            $approvs->hrd_approv='1';
                            $approvs->save();
            
                            $approvRecords = new ApprovalRecord();
                            $approvRecords->doc=$approvs->id;
                            $approvRecords->user_id=Auth::user()->id;
                            $approvRecords->level='2';
                            $approvRecords->type='cuti';
                            $approvRecords->active='1';
                            $approvRecords->save();

                            if($bigLeaveChecks!=0){
                                $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                                $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                                $bigLeaveClaims->hrd_approv='1';
                                $bigLeaveClaims->save();
                            }
                        } 
                        
                        if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                            $approvs = DayOf::whereId($this->dayOfId)->first();
                            $approvs->sm_approv='1';
                            $approvs->approv='1';
                            $approvs->save();
            
                            $approvRecords = new ApprovalRecord();
                            $approvRecords->doc=$approvs->id;
                            $approvRecords->user_id=Auth::user()->id;
                            $approvRecords->level='3';
                            $approvRecords->type='cuti';
                            $approvRecords->active='1';
                            $approvRecords->save();
    
                            if($annualLeaveChecks!=0){
                                $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                                $annualLeaves->approv='1';
                                $annualLeaves->save();
                            }
    
                            if($bigLeaveChecks!=0){
                                $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                                $bigLeaves->approv='1';
                                $bigLeaves->save();

                                $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                                $bigLeaveClaims->sm_approv='1';
                                $bigLeaveClaims->approv='1';
                                $bigLeaveClaims->save();
                            }
                        } 
                    }
                }
                $this->emit('flashMessage',[
                    'type'=>'success',
                    'title'=>'Approv Data',
                    'message'=>'Berhasil approv data!'
                ]);
                $this->approvMode = false;
                $this->emit('closeModal','approvModal');
                $this->emit('reloadDayOfs');
                $this->initializedProperties();  
            }catch(\Throwable $th){
                DB::rollBack();
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Approv Data',
                    'message'=>'Error:'.$th->getMessage()
                ]);
            }
            DB::commit();
        }

        public function notApprovStore(){
            $this->validate();
            $checkStaff=DayOf::whereId($this->dayOfId)->first();
            $annualLeaveChecks=AnnualLeave::where('day_of_id',$this->dayOfId)->count();
            $bigLeaveChecks=BigLeave::where('day_of_id',$this->dayOfId)->count();
            DB::beginTransaction();
            try{
                if($checkStaff->user->level=='department_head'){
                    if(Auth::user()->hr_head=='1'){
                        $approvs = DayOf::whereId($this->dayOfId)->first();
                        $approvs->hrd_approv='2';
                        $approvs->approv='2';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->reason=$this->reason;
                        $approvRecords->level='1';
                        $approvRecords->type='cuti';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($annualLeaveChecks!=0){
                            $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                            $annualLeaves->approv='2';
                            $annualLeaves->save();
                        }
    
                        if($bigLeaveChecks!=0){
                            $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                            $bigLeaves->approv='2';
                            $bigLeaves->save();

                            $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                            $bigLeaveClaims->approv='2';
                            $bigLeaveClaims->save();
                        }  
                    }
                    if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                        $approvs = DayOf::whereId($this->dayOfId)->first();
                        $approvs->sm_approv='2';
                        $approvs->approv='2';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->reason=$this->reason;
                        $approvRecords->level='2';
                        $approvRecords->type='cuti';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($annualLeaveChecks!=0){
                            $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                            $annualLeaves->approv='2';
                            $annualLeaves->save();
                        }
                        if($bigLeaveChecks!=0){
                            $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                            $bigLeaves->approv='2';
                            $bigLeaves->save();

                            $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                            $bigLeaveClaims->approv='2';
                            $bigLeaveClaims->save();
                        } 
                    }  
                }
                if($checkStaff->user->level=='site_manager'){
                    if(Auth::user()->hr_head=='1'){
                        $approvs = DayOf::whereId($this->dayOfId)->first();
                        $approvs->hrd_approv='2';
                        $approvs->approv='2';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->reason=$this->reason;
                        $approvRecords->level='1';
                        $approvRecords->type='cuti';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($annualLeaveChecks!=0){
                            $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                            $annualLeaves->approv='2';
                            $annualLeaves->save();
                        }
    
                        if($bigLeaveChecks!=0){
                            $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                            $bigLeaves->approv='2';
                            $bigLeaves->save();

                            $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                            $bigLeaveClaims->approv='2';
                            $bigLeaveClaims->save();
                        }  
                    }
                    if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                        $approvs = DayOf::whereId($this->dayOfId)->first();
                        $approvs->sm_approv='2';
                        $approvs->approv='2';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->reason=$this->reason;
                        $approvRecords->level='2';
                        $approvRecords->type='cuti';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($annualLeaveChecks!=0){
                            $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                            $annualLeaves->approv='2';
                            $annualLeaves->save();
                        }
                        if($bigLeaveChecks!=0){
                            $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                            $bigLeaves->approv='2';
                            $bigLeaves->save();

                            $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                            $bigLeaveClaims->approv='2';
                            $bigLeaveClaims->save();
                        } 
                    }  
                }
                if($checkStaff->user->level=='employee' or $checkStaff->user->level=='hrd_admin'){
                    if($checkStaff->user->staff=='0'){
                        if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='0'){
                            $approvs = DayOf::whereId($this->dayOfId)->first();
                            $approvs->head_approv='2';
                            $approvs->approv='2';
                            $approvs->save();
        
                            $approvRecords = new ApprovalRecord();
                            $approvRecords->doc=$approvs->id;
                            $approvRecords->user_id=Auth::user()->id;
                            $approvRecords->reason=$this->reason;
                            $approvRecords->level='1';
                            $approvRecords->type='cuti';
                            $approvRecords->active='1';
                            $approvRecords->save();
        
                            if($annualLeaveChecks!=0){
                                $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                                $annualLeaves->approv='2';
                                $annualLeaves->save();
                            }
        
                            if($bigLeaveChecks!=0){
                                $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                                $bigLeaves->approv='2';
                                $bigLeaves->save();

                                $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                                $bigLeaveClaims->approv='2';
                                $bigLeaveClaims->save();
                            } 
                        }
                        if(Auth::user()->hr_head=='1'){
                            $approvs = DayOf::whereId($this->dayOfId)->first();
                            $approvs->hrd_approv='2';
                            $approvs->approv='2';
                            $approvs->save();
            
                            $approvRecords = new ApprovalRecord();
                            $approvRecords->doc=$approvs->id;
                            $approvRecords->user_id=Auth::user()->id;
                            $approvRecords->reason=$this->reason;
                            $approvRecords->level='2';
                            $approvRecords->type='cuti';
                            $approvRecords->active='1';
                            $approvRecords->save();
        
                            if($annualLeaveChecks!=0){
                                $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                                $annualLeaves->approv='2';
                                $annualLeaves->save();
                            }
        
                            if($bigLeaveChecks!=0){
                                $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                                $bigLeaves->approv='2';
                                $bigLeaves->save();

                                $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                                $bigLeaveClaims->approv='2';
                                $bigLeaveClaims->save();
                            }  
                        }
                    }else{
                        if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='0'){
                            $approvs = DayOf::whereId($this->dayOfId)->first();
                            $approvs->head_approv='2';
                            $approvs->approv='2';
                            $approvs->save();
            
                            $approvRecords = new ApprovalRecord();
                            $approvRecords->doc=$approvs->id;
                            $approvRecords->user_id=Auth::user()->id;
                            $approvRecords->reason=$this->reason;
                            $approvRecords->level='1';
                            $approvRecords->type='cuti';
                            $approvRecords->active='1';
                            $approvRecords->save();
        
                            if($annualLeaveChecks!=0){
                                $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                                $annualLeaves->approv='2';
                                $annualLeaves->save();
                            }
                            if($bigLeaveChecks!=0){
                                $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                                $bigLeaves->approv='2';
                                $bigLeaves->save();

                                $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                                $bigLeaveClaims->approv='2';
                                $bigLeaveClaims->save();
                            }  
                        }
                        if(Auth::user()->hr_head=='1'){
                            $approvs = DayOf::whereId($this->dayOfId)->first();
                            $approvs->hrd_approv='2';
                            $approvs->approv='2';
                            $approvs->save();
            
                            $approvRecords = new ApprovalRecord();
                            $approvRecords->doc=$approvs->id;
                            $approvRecords->user_id=Auth::user()->id;
                            $approvRecords->reason=$this->reason;
                            $approvRecords->level='2';
                            $approvRecords->type='cuti';
                            $approvRecords->active='1';
                            $approvRecords->save();
        
                            if($annualLeaveChecks!=0){
                                $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                                $annualLeaves->approv='2';
                                $annualLeaves->save();
                            }
        
                            if($bigLeaveChecks!=0){
                                $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                                $bigLeaves->approv='2';
                                $bigLeaves->save();

                                $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                                $bigLeaveClaims->approv='2';
                                $bigLeaveClaims->save();
                            }  
                        } 
                        if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                            $approvs = DayOf::whereId($this->dayOfId)->first();
                            $approvs->sm_approv='2';
                            $approvs->approv='2';
                            $approvs->save();
            
                            $approvRecords = new ApprovalRecord();
                            $approvRecords->doc=$approvs->id;
                            $approvRecords->user_id=Auth::user()->id;
                            $approvRecords->reason=$this->reason;
                            $approvRecords->level='3';
                            $approvRecords->type='cuti';
                            $approvRecords->active='1';
                            $approvRecords->save();
        
                            if($annualLeaveChecks!=0){
                                $annualLeaves = AnnualLeave::where('day_of_id',$this->dayOfId)->first();
                                $annualLeaves->approv='2';
                                $annualLeaves->save();
                            }
                            if($bigLeaveChecks!=0){
                                $bigLeaves = BigLeave::where('day_of_id',$this->dayOfId)->first();
                                $bigLeaves->approv='2';
                                $bigLeaves->save();

                                $bigLeaveClaims = BigLeaveClaim::where('big_leave_id',$bigLeaves->id)->first();
                                $bigLeaveClaims->approv='2';
                                $bigLeaveClaims->save();
                            } 
                        }  
                    }
                }
                $this->emit('flashMessage',[
                    'type'=>'success',
                    'title'=>'Tidak Approv Data',
                    'message'=>'Berhasil tidak approv data!'
                ]);
                $this->emit('closeModal','notApprovModal');
                $this->emit('reloadDayOfs');
                $this->initializedProperties();            
            }catch(\Throwable $th){
                DB::rollBack();
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Tidak Approv Data',
                    'message'=>'Error:'.$th->getMessage()
                ]);
            }
            DB::commit();
        }

        private function initializedProperties(){
            $this->dayOfId;
            $this->site;
            $this->position;
            $this->department;
            $this->nrp;
            $this->employeeId;
            $this->employee;
    
            $this->startDate;
            $this->endDate;
            $this->inDate;
            $this->number;
    
            $this->description;
    
            $this->workDay;
    
            $this->dayOfSum;
    
            $this->ticketDateFromGo;
            $this->ticketDateFromBack;
            $this->ticketTimeGo;
            $this->ticketTimeBack;
    
            $this->travelDateFromGo;
            $this->travelDateFromBack;
            $this->travelFromGo=null;
    
           /* $this->headApprov;
            $this->hrdApprov;
            $this->smApprov;*/
    
            $this->annualLeaveStartDate;
            $this->annualLeaveEndDate;
            $this->annualLeaveLess;
            //$this->annualLeaveShould;
                            
            $this->bigLeaveStartDate;
            $this->bigLeaveEndDate;
            $this->bigLeaveLess;
            //$this->bigLeaveShould;

            $this->reason=null;
    
    
        }

        public function cancel()
        {
            $this->approvMode = false;
            $this->notApprovMode = false;
            $this->resetErrorBag();
            $this->initializedProperties();
            $this->emit('closeModal','approvModal');
            $this->emit('closeModal','notApprovModal');
        }

}
