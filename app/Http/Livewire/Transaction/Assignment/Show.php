<?php

namespace App\Http\Livewire\Transaction\Assignment;

use Livewire\Component;
use App\Models\Assignment;
use App\Models\ApprovalRecord;
use App\Models\AssignmentDestination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Auth;
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

    // Show Modal Approv & Not Approv

    public $assignmentId;
    public $employeeId;
    public $employeeLevel;
    public $number;
    public $site;
    public $nrp;
    public $name;
    public $position;
    public $department;
    public $departmentId;
    public $address;
    public $phone;
    public $startDate;
    public $endDate;
    public $inDate;
    public $location;
    public $sumDay;
    public $ticketDateFromGo;
    public $ticketDateFromBack;
    public $ticketTimeGo;
    public $ticketTimeBack;
    public $travelDateFromGo;
    public $travelDateFromBack;
    public $description;
    public $lodgingCost;
    public $transportCost;
    public $mealCost;
    public $otherCost;
    public $lodgingDay;
    public $transportDay;
    public $mealDay;
    public $otherDay;

    public $lodgingCostTotal;
    public $transportCostTotal;
    public $mealCostTotal;
    public $otherCostTotal;
    public $costGrandTotal;
    public $countedGrandTotal;

    public $destinationFromGoTicket;
    public $destinationToGoTicket;
    public $destinationFromBackTicket;
    public $destinationToBackTicket;
    public $destinationFromGoTravel;
    public $destinationToGoTravel; 
    public $destinationFromBackTravel;
    public $destinationToBackTravel;


    public $approvMode = false;
    public $notApprovMode = false;
    public $deleteMode = false;

    public $reason;

    public $change='';

    protected $paginationTheme = 'bootstrap';
    protected $listeners=[
        'reloadAssignments'=>'$refresh'
    ];

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $rules = [
        'lodgingDay'=>'required|digits_between:1,2|not_in:0',
        'transportDay'=>'required|digits_between:1,2|not_in:0',
        'mealDay'=>'required|numeric|digits_between:1,2|not_in:0',
        'otherDay'=>'required|numeric|digits_between:1,2|not_in:0',
        'lodgingCost'=>'required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
        'transportCost'=>'required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
        'mealCost'=>'required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
        'otherCost'=>'required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'numeric'=>':attribute menggunakan format angka',
        'digits_between'=>':attribute menggunakan 1 karakter s/d 2 karakter',
        'not_in'=>':attribute tdl boleh menggunakan angka 0',
        'not_regex'=>':attribute karakter tdk valid',
    ];

    protected $validationAttributes = [
        'lodgingDay'=>'Jml hari penginapan',
        'lodgingCost'=>'Biaya penginapan perhari',
        'transportDay'=>'Jml hari transportasi',
        'transportCost'=>'Biaya transport perhari',
        'mealDay'=>'Jml hari makan',
        'mealCost'=>'Biaya makan perhari',
        'otherDay'=>'Jml hari lain2',
        'otherCost'=>'Biaya lain2 perhari',
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

        $assignments = Assignment::where('id',$this->assignmentId)->first();
        if($assignments->location!='inSite'){
            if(is_numeric(currencyIDRToNumeric($this->lodgingDay)) and is_numeric(currencyIDRToNumeric($this->lodgingCost)) and is_numeric(currencyIDRToNumeric($this->transportDay)) and is_numeric(currencyIDRToNumeric($this->transportCost)) and is_numeric(currencyIDRToNumeric($this->mealDay)) and is_numeric(currencyIDRToNumeric($this->mealCost)) and is_numeric(currencyIDRToNumeric($this->otherDay)) and is_numeric(currencyIDRToNumeric($this->otherCost))){
            if($this->lodgingCost==''){
                $lodgingCostChecks=0;
            }else{
                $lodgingCostChecks=$this->lodgingCost;
            }
            if($this->lodgingDay==''){
                $lodgingDayChecks=0;
            }else{
                $lodgingDayChecks=$this->lodgingDay;
            }
            if($this->transportCost==''){
                $transportCostChecks=0;
            }else{
                $transportCostChecks=$this->transportCost;
            }
            if($this->transportDay==''){
                $transportDayChecks=0;
            }else{
                $transportDayChecks=$this->transportDay;
            }
            if($this->mealCost==''){
                $mealCostChecks=0;
            }else{
                $mealCostChecks=$this->mealCost;
            }
            if($this->mealDay==''){
                $mealDayChecks=0;
            }else{
                $mealDayChecks=$this->mealDay;
            }
            if($this->otherCost==''){
                $otherCostChecks=0;
            }else{
                $otherCostChecks=$this->otherCost;
            }
            if($this->otherDay==''){
                $otherDayChecks=0;
            }else{
                $otherDayChecks=$this->otherDay;
            }
            $this->lodgingCostTotal=currency_IDR(currencyIDRToNumeric($lodgingCostChecks) * $lodgingDayChecks);
            $this->transportCostTotal=currency_IDR(currencyIDRToNumeric($transportCostChecks) * $transportDayChecks);
            $this->mealCostTotal=currency_IDR(currencyIDRToNumeric($mealCostChecks) * $mealDayChecks);
            $this->otherCostTotal=currency_IDR(currencyIDRToNumeric($otherCostChecks )* $otherDayChecks);
            $this->costGrandTotal=currency_IDR((currencyIDRToNumeric($lodgingCostChecks) * $lodgingDayChecks)+(currencyIDRToNumeric($transportCostChecks) *$transportDayChecks)+(currencyIDRToNumeric($mealCostChecks) * $mealDayChecks)+(currencyIDRToNumeric($otherCostChecks ) * $otherDayChecks));
            }
        }
    }

   /* public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

    }*/
    
    public function render()
    {
        $this->emit('resetSelect2');
        if($this->status==null){
            $qry="1";
        }
        else{
            $qry=$this->status;
        } 
        $siteCheck=Auth::user()->site_id;
        $departmentCheck=Auth::user()->position->department->id;
        $assignments=Assignment::query()->select('assignments.id','assignments.user_id','assignments.site_id','assignments.start_date','assignments.end_date','assignments.in_date','assignments.sum_day'
            ,'assignments.ticket_date_from_go','assignments.ticket_date_from_back','assignments.ticket_time_from_go'
            ,'assignments.ticket_time_from_back','assignments.travel_date_from_go','assignments.travel_date_from_back' ,'assignments.description'
            ,'assignments.lodging_cost','assignments.transportation_cost','assignments.meal_cost','assignments.other_cost'
            ,'assignments.lodging_day','assignments.transportation_day','assignments.meal_day','assignments.other_day','assignments.location'
            ,'assignments.head_approv','assignments.sm_approv','assignments.hrd_approv','assignments.approv','assignments.active','assignments.created_at'
                ,'a.nrp','a.name','a.position_id','c.name as position','c.department_id','d.name as department'
                )                
                ->join('users as a', 'a.id', '=', 'assignments.user_id')
                ->join('sites as b', 'assignments.site_id', '=', 'b.id')
                ->join('positions as c', 'a.position_id', '=', 'c.id')
                ->join('departments as d', 'c.department_id', '=', 'd.id')
                ->orWhere(function($query)  {
                    $query->where('a.name','like','%'.trim($this->search).'%')
                          ->orWhere('a.nrp','like','%'.trim($this->search).'%')
                          ->orWhere('b.name','like','%'.trim($this->search).'%')
                          ;
                })
                ->SAssignmentWhere($qry,$siteCheck,$departmentCheck)
                //->where('assignments.user_id','!=',Auth::user()->id)  
                ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
        return view('livewire.transaction.assignment.show',compact('assignments'));
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

    public function preview($id){
        $assignments=Assignment::find($id);
        $destinationGoTickets=AssignmentDestination::select('b.name as from','c.name as to','destination')
            ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
            ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
            ->where('assignment_id',$assignments->id)->where('type','Go')->where('destination','Ticket')->first();
        $destinationBackTickets=AssignmentDestination::select('b.name as from','c.name as to','destination')
            ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
            ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
            ->where('assignment_id',$assignments->id)->where('type','Back')->where('destination','Ticket')->first();

        $destinationGoTravels=AssignmentDestination::select('b.name as from','c.name as to','destination')
            ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
            ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
            ->where('assignment_id',$assignments->id)->where('type','Go')->where('destination','Travel')->first();
        $destinationBackTravels=AssignmentDestination::select('b.name as from','c.name as to','destination')
            ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
            ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
            ->where('assignment_id',$assignments->id)->where('type','Back')->where('destination','Travel')->first();

        $approvalRecords=ApprovalRecord::select('a.head_approv','a.hrd_approv','a.sm_approv','c.level as level_approv','c.nrp','c.name as approver','c.hr_head','approval_records.level as level_order','approval_records.created_at')
            ->leftjoin('assignments as a', 'a.id', '=', 'approval_records.doc')
            ->join('users as b', 'b.id', '=', 'a.user_id')  
            ->leftjoin('users as c', 'c.id', '=', 'approval_records.user_id')        
            ->where('approval_records.doc',$assignments->id)->where('approval_records.type','dinas')->get();
            
          return view('livewire.transaction.assignment.preview',
             [
                'assignments'=>$assignments,
                'destinationGoTickets'=>$destinationGoTickets,
                'destinationBackTickets'=>$destinationBackTickets,
                'destinationGoTravels'=>$destinationGoTravels,
                'destinationBackTravels'=>$destinationBackTravels,
                'approvalRecords'=>$approvalRecords
            ]); 
    }

    public function print($id){
        $assignments=Assignment::find($id);
        $destinationGoTickets=AssignmentDestination::select('b.name as from','c.name as to','destination')
            ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
            ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
            ->where('assignment_id',$assignments->id)->where('type','Go')->where('destination','Ticket')->first();
        $destinationBackTickets=AssignmentDestination::select('b.name as from','c.name as to','destination')
            ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
            ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
            ->where('assignment_id',$assignments->id)->where('type','Back')->where('destination','Ticket')->first();

        $destinationGoTravels=AssignmentDestination::select('b.name as from','c.name as to','destination')
            ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
            ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
            ->where('assignment_id',$assignments->id)->where('type','Go')->where('destination','Travel')->first();
        $destinationBackTravels=AssignmentDestination::select('b.name as from','c.name as to','destination')
            ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
            ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
            ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
            ->where('assignment_id',$assignments->id)->where('type','Back')->where('destination','Travel')->first();

        $approvalRecords=ApprovalRecord::select('a.head_approv','a.hrd_approv','a.sm_approv','c.level as level_approv','c.nrp','c.name as approver','c.hr_head','approval_records.level as level_order','approval_records.created_at')
            ->leftjoin('assignments as a', 'a.id', '=', 'approval_records.doc')
            ->join('users as b', 'b.id', '=', 'a.user_id')  
            ->leftjoin('users as c', 'c.id', '=', 'approval_records.user_id')        
            ->where('approval_records.doc',$assignments->id)->where('approval_records.type','dinas')->get();
            
          return view('livewire.transaction.assignment.print',
             [
                'assignments'=>$assignments,
                'destinationGoTickets'=>$destinationGoTickets,
                'destinationBackTickets'=>$destinationBackTickets,
                'destinationGoTravels'=>$destinationGoTravels,
                'destinationBackTravels'=>$destinationBackTravels,
                'approvalRecords'=>$approvalRecords
            ]); 
    }

    public function showModalApprov($id)
    {
        $this->approvMode = true;
        $this->notApprovMode = false;
        $this->emit('closeModal','notApprovModal');
        $assignments = Assignment::where('id',$id)->first();
        $this->assignmentId=$assignments->id;
        $this->employeeId=$assignments->user_id;
        $this->site=$assignments->site->name;
        $this->nrp=$assignments->user->nrp;
        $this->name=$assignments->user->name;
        $this->employeeLevel=$assignments->user->level;
        $this->position=$assignments->user->position->name;
        $this->department=$assignments->user->position->department->name;
        $this->departmentId=$assignments->user->position->department->id;
        $this->address=trim($assignments->user->address);
        $this->phone=trim($assignments->user->phone);
        $this->number=trim($assignments->number);
        $this->startDate=date('d/m/Y',strtotime($assignments->start_date));
        $this->endDate=date('d/m/Y',strtotime($assignments->end_date));
        $this->inDate=date('d/m/Y',strtotime($assignments->in_date));
        $this->sumDay=$assignments->sum_day;
        $this->location=$assignments->location;
        $this->ticketDateFromGo=date('d/m/Y',strtotime($assignments->ticket_date_from_go));
        $this->ticketDateFromBack=date('d/m/Y',strtotime($assignments->ticket_date_from_back));
        $this->ticketTimeGo=date('H:i',strtotime($assignments->ticket_time_from_go));
        $this->ticketTimeBack=date('H:i',strtotime($assignments->ticket_time_from_back));
        $this->travelDateFromGo=date('d/m/Y',strtotime($assignments->travel_date_from_go));
        $this->travelDateFromBack=date('d/m/Y',strtotime($assignments->travel_date_from_back));
        $this->description=$assignments->description;
        $this->lodgingCost=currency_IDR($assignments->lodging_cost);
        $this->transportCost=currency_IDR($assignments->transportation_cost);
        $this->mealCost=currency_IDR($assignments->meal_cost);
        $this->otherCost=currency_IDR($assignments->other_cost);
        $this->lodgingDay=$assignments->lodging_day;
        $this->transportDay=$assignments->transportation_day;
        $this->mealDay=$assignments->meal_day;
        $this->otherDay=$assignments->other_day;
        if($assignments->location=='inSite'){
            $this->mealCostTotal=currency_IDR($assignments->meal_cost * $assignments->meal_day);
            $this->otherCostTotal=currency_IDR($assignments->other_cost * $assignments->other_day);
            $this->costGrandTotal=currency_IDR(($assignments->meal_cost * $assignments->meal_day)+($assignments->other_cost * $assignments->other_day));
            $this->countedGrandTotal=terbilang(($assignments->meal_cost * $assignments->meal_day)+($assignments->other_cost * $assignments->other_day));
        }
        else{
            $this->lodgingCostTotal=currency_IDR($assignments->lodging_cost * $assignments->lodging_day);
            $this->transportCostTotal=currency_IDR($assignments->transportation_cost * $assignments->transportation_day);
            $this->mealCostTotal=currency_IDR($assignments->meal_cost * $assignments->meal_day);
            $this->otherCostTotal=currency_IDR($assignments->other_cost * $assignments->other_day);
            $this->costGrandTotal=currency_IDR(($assignments->lodging_cost * $assignments->lodging_day)+($assignments->transportation_cost * $assignments->transportation_day)+($assignments->meal_cost * $assignments->meal_day)+($assignments->other_cost * $assignments->other_day));
            $this->countedGrandTotal=terbilang(($assignments->lodging_cost * $assignments->lodging_day)+($assignments->transportation_cost * $assignments->transportation_day)+($assignments->meal_cost * $assignments->meal_day)+($assignments->other_cost * $assignments->other_day));
        }
        if($assignments->location=='outRegional'){
            $destinationGoTickets=AssignmentDestination::select('b.name as from','c.name as to','destination')
                ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
                ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
                ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
                ->where('assignment_id',$assignments->id)->where('type','Go')->where('destination','Ticket')->first();
            $destinationBackTickets=AssignmentDestination::select('b.name as from','c.name as to','destination')
                ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
                ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
                ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
                ->where('assignment_id',$assignments->id)->where('type','Back')->where('destination','Ticket')->first();

                $this->destinationFromGoTicket=$destinationGoTickets->from;
                $this->destinationToGoTicket=$destinationGoTickets->to;
                $this->destinationFromBackTicket=$destinationBackTickets->from;
                $this->destinationToBackTicket=$destinationBackTickets->to;
        }
        if($assignments->location=='inRegional' or $assignments->location=='outRegional'){
            $destinationGoTravels=AssignmentDestination::select('b.name as from','c.name as to','destination')
                ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
                ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
                ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
                ->where('assignment_id',$assignments->id)->where('type','Go')->where('destination','Travel')->first();
            $destinationBackTravels=AssignmentDestination::select('b.name as from','c.name as to','destination')
                ->join('assignments as a', 'a.id', '=', 'assignment_destinations.assignment_id')
                ->join('destinations as b', 'b.id', '=', 'assignment_destinations.from_id')
                ->join('destinations as c', 'c.id', '=', 'assignment_destinations.to_id')            
                ->where('assignment_id',$assignments->id)->where('type','Back')->where('destination','Travel')->first();
                
            $this->destinationFromGoTravel=$destinationGoTravels->from;
            $this->destinationToGoTravel=$destinationGoTravels->to; 
            $this->destinationFromBackTravel=$destinationBackTravels->from;
            $this->destinationToBackTravel=$destinationBackTravels->to; 
        }
        
    }

    public function showModalNotApprov(Assignment $assignments)
    {
        $this->notApprovMode = true;
        $this->approvMode = false;
        $this->emit('closeModal','approvModal');
        $this->assignmentId=$assignments->id;
        $this->employeeId=$assignments->user_id;
        $this->site=$assignments->site->name;
        $this->nrp=$assignments->user->nrp;
        $this->name=$assignments->user->name;
    }

    public function showModalDelete(Assignment $assignments)
    {
        $this->deleteMode = true;
        $this->approvMode = false;
        $this->notApprovMode = false;
        $this->emit('closeModal','approvModal');
        $this->emit('closeModal','notApprovModal');
        $this->assignmentId=$assignments->id;
        $this->employeeId=$assignments->user_id;
        $this->site=$assignments->site->name;
        $this->nrp=$assignments->user->nrp;
        $this->name=$assignments->user->name;
        $this->number=trim($assignments->number);
    }

    public function approvStore(){
        if($this->change=='change'){

        $this->validate();
        }
        DB::beginTransaction();
        try{
            $getAssignments = Assignment::whereId($this->assignmentId)->first();
            if($getAssignments->user->level=='department_head'){
                if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                    $approvs = Assignment::whereId($this->assignmentId)->first();
                    $approvs->sm_approv='1';
                    $approvs->approv='1';
                    $approvs->save();
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->level='1';
                    $approvRecords->type='dinas';
                    $approvRecords->active='1';
                    $approvRecords->save();

                    if($this->change=='change'){
                        $assignments = Assignment::whereId($this->assignmentId)->first();
                        $assignments->lodging_cost =currencyIDRToNumeric($this->lodgingCost);
                        $assignments->transportation_cost =currencyIDRToNumeric($this->transportCost);
                        $assignments->meal_cost =currencyIDRToNumeric($this->mealCost);
                        $assignments->other_cost =currencyIDRToNumeric($this->otherCost);
                        $assignments->lodging_day =$this->lodgingDay;
                        $assignments->transportation_day =$this->transportDay;
                        $assignments->meal_day =$this->mealDay;	
                        $assignments->other_day =$this->otherDay;
                        $assignments->save();
                    }
                }
            }
            if($getAssignments->user->level=='site_manager'){
                if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                    $approvs = Assignment::whereId($this->assignmentId)->first();
                    $approvs->sm_approv='1';
                    $approvs->approv='1';
                    $approvs->save();
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->level='1';
                    $approvRecords->type='dinas';
                    $approvRecords->active='1';
                    $approvRecords->save();

                    if($this->change=='change'){
                        $assignments = Assignment::whereId($this->assignmentId)->first();
                        $assignments->lodging_cost =currencyIDRToNumeric($this->lodgingCost);
                        $assignments->transportation_cost =currencyIDRToNumeric($this->transportCost);
                        $assignments->meal_cost =currencyIDRToNumeric($this->mealCost);
                        $assignments->other_cost =currencyIDRToNumeric($this->otherCost);
                        $assignments->lodging_day =$this->lodgingDay;
                        $assignments->transportation_day =$this->transportDay;
                        $assignments->meal_day =$this->mealDay;	
                        $assignments->other_day =$this->otherDay;
                        $assignments->save();
                    }
                }
            }
            if($getAssignments->user->level=='employee' or $getAssignments->user->level=='hrd_admin'){
                if(Auth::user()->level=='department_head'){
                    $approvs = Assignment::whereId($this->assignmentId)->first();
                    $approvs->head_approv='1';
                    $approvs->save();
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->level='1';
                    $approvRecords->type='dinas';
                    $approvRecords->active='1';
                    $approvRecords->save();

                    if($this->change=='change'){
                        $assignments = Assignment::whereId($this->assignmentId)->first();
                        $assignments->lodging_cost =currencyIDRToNumeric($this->lodgingCost);
                        $assignments->transportation_cost =currencyIDRToNumeric($this->transportCost);
                        $assignments->meal_cost =currencyIDRToNumeric($this->mealCost);
                        $assignments->other_cost =currencyIDRToNumeric($this->otherCost);
                        $assignments->lodging_day =$this->lodgingDay;
                        $assignments->transportation_day =$this->transportDay;
                        $assignments->meal_day =$this->mealDay;	
                        $assignments->other_day =$this->otherDay;
                        $assignments->save();
                    }
                }
                if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                    $approvs = Assignment::whereId($this->assignmentId)->first();
                    $approvs->sm_approv='1';
                    $approvs->approv='1';
                    $approvs->save();
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->level='2';
                    $approvRecords->type='dinas';
                    $approvRecords->active='1';
                    $approvRecords->save();
                }
            }
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Approv Data',
                'message'=>'Berhasil approv data!'
            ]);
            $this->approvMode = false;
            $this->emit('closeModal','approvModal');
            $this->emit('reloadAssignments');
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
        $rules = [
            'reason' => 'required|min:10|max:500|',
        ];
    
        $messages = [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute minimal :min karakter!',
            'max' => ':attribute maksimal :max karakter!',
        ];

        $validationAttributes = [
            'reason' => 'Alasan tidak menyetujui',
        ];

        $this->validate($rules, $messages,$validationAttributes);
        DB::beginTransaction();
        try{
            $getAssignments = Assignment::whereId($this->assignmentId)->first();
            if($getAssignments->user->level=='department_head'){
                if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                    $approvs = Assignment::whereId($this->assignmentId)->first();
                    $approvs->sm_approv='2';
                    $approvs->approv='2';
                    $approvs->save();
        
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->reason=$this->reason;
                    $approvRecords->level='1';
                    $approvRecords->type='dinas';
                    $approvRecords->active='1';
                    $approvRecords->save();
                }
            }

            if($getAssignments->user->level=='site_manager'){
                if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                    $approvs = Assignment::whereId($this->assignmentId)->first();
                    $approvs->sm_approv='2';
                    $approvs->approv='2';
                    $approvs->save();
        
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->reason=$this->reason;
                    $approvRecords->level='1';
                    $approvRecords->type='dinas';
                    $approvRecords->active='1';
                    $approvRecords->save();
                }
            }

            if($getAssignments->user->level=='employee' or $getAssignments->user->level=='hrd_admin'){
                if(Auth::user()->level=='department_head'){
                    $approvs = Assignment::whereId($this->assignmentId)->first();
                    $approvs->head_approv='2';
                    $approvs->approv='2';
                    $approvs->save();
    
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->reason=$this->reason;
                    $approvRecords->level='1';
                    $approvRecords->type='dinas';
                    $approvRecords->active='1';
                    $approvRecords->save(); 
                }
    
                if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                    $approvs = Assignment::whereId($this->assignmentId)->first();
                    $approvs->sm_approv='2';
                    $approvs->approv='2';
                    $approvs->save();
    
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->reason=$this->reason;
                    $approvRecords->level='2';
                    $approvRecords->type='dinas';
                    $approvRecords->active='1';
                    $approvRecords->save();
                    }
            }

            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Not Approv Data',
                'message'=>'Proses berhasil!'
            ]);

            $this->notApproveMode = false;
            $this->emit('closeModal','notApprovModal');
            $this->emit('reloadAssignments');
            $this->initializedProperties();            
        }catch(\Throwable $th){
            DB::rollBack();
            $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Not Approv Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
        }
        DB::commit();
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
        $this->employeeLevel=null;
        $this->site=null;
        $this->nrp=null;
        $this->name=null;
        $this->position=null;
        $this->department=null;
        $this->departmentId=null;
        $this->address=null;
        $this->phone=null;
        $this->number=null;
        $this->startDate=null;
        $this->endDate=null;
        $this->inDate=null;
        $this->sumDay=null;
        $this->location=null;
        $this->ticketDateFromGo=null;
        $this->ticketDateFromBack=null;
        $this->ticketTimeGo=null;
        $this->ticketTimeBack=null;
        $this->travelDateFromGo=null;
        $this->travelDateFromBack=null;
        $this->description=null;
        $this->lodgingCost=null;
        $this->transportCost=null;
        $this->mealCost=null;
        $this->otherCost=null;
        $this->lodgingDay=null;
        $this->transportDay=null;
        $this->mealDay=null;
        $this->otherDay=null;

        $this->lodgingCostTotal=null;
        $this->transportCostTotal=null;
        $this->mealCostTotal=null;
        $this->otherCostTotal=null;
        $this->costGrandTotal=null;
        $this->countedGrandTotal=null;

        $this->destinationFromGoTicket=null;
        $this->destinationToGoTicket=null;
        $this->destinationFromBackTicket=null;
        $this->destinationToBackTicket=null;
        $this->destinationFromGoTravel=null;
        $this->destinationToGoTravel=null; 
        $this->destinationFromBackTravel=null;
        $this->destinationToBackTravel=null; 

        $this->reason=null;

        $this->change=null;
    }

    public function cancel()
    {
        $this->approvMode = false;
        $this->notApprovMode = false;
        $this->deleteMode = false;
        $this->resetErrorBag();
        $this->initializedProperties();
        $this->emit('closeModal','approvModal');
        $this->emit('closeModal','notApprovModal');
        $this->emit('closeModal','deleteModal');
    }

}
