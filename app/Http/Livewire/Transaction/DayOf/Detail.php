<?php

namespace App\Http\Livewire\Transaction\DayOf;

use App\Models\AnnualLeave;
use Livewire\Component;
use App\Models\DayOf;
use App\Models\DayOfDestination;
use App\Models\ApprovalRecord;
use App\Models\BigLeave;
use App\Models\User;
class Detail extends Component
{
    public $number;
    public $employeeId;
    public $employeeLevel;
    public $dayOfId;
    public $nrp;
    public $name;
    public $position;
    public $department;
    public $site;
    public $address;
    public $phone;
    public $start;
    public $end;
    public $in;

    public $inBefore;
    public $workDay;

    public $dayOfSum;

    public $annualLeaveStart;
    public $annualLeaveEnd;
    public $annualLeaveLess;
    public $annualLeaveShould;

    public $bigLeaveStart;
    public $bigLeaveEnd;
    public $bigLeaveLess;
    public $bigLeaveShould;

    public $destinationFromGoTicket;
    public $destinationToGoTicket;
    public $destinationFromBackTicket;
    public $destinationToBackTicket;
    public $destinationFromGoTravel;
    public $destinationToGoTravel; 
    public $destinationFromBackTravel;
    public $destinationToBackTravel; 

    public $ticketDateFromGo;
    public $ticketDateFromBack;
    public $ticketTimeFromGo;
    public $ticketTimeFromBack;

    public $travelDateFromGo;
    public $travelDateFromBack;

    public $dayOfStandartTravelDay;
    public $dayOfStandartTicketDay;

    public $headApprov;
    public $hrdApprov;
    public $smApprov;

    protected $listeners=[
        'detailDayOf'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }


    public function showModal(DayOf $dayOfs){
        $this->employeeId=$dayOfs->user->id;
        $this->dayOfId=$dayOfs->id;
        $this->nrp=$dayOfs->user->nrp;
        $this->name=$dayOfs->user->name;
        $this->position=$dayOfs->user->position->name;
        $this->department=$dayOfs->user->position->department->name;
        $this->site=$dayOfs->user->site->name;
        $this->address=$dayOfs->user->address;
        $this->phone=$dayOfs->user->phone;
        $this->employeeLevel=$dayOfs->user->level;
        $this->start=$dayOfs->start;
        $this->end=$dayOfs->end;
        $this->in=$dayOfs->in;
        $this->number=$dayOfs->number;
        $this->inBefore=$dayOfs->in_before;

        $this->workDay=$dayOfs->work_day;

        $this->dayOfSum=$dayOfs->day_of_sum;

        $this->ticketDateFromGo=$dayOfs->ticket_from_go;
        $this->ticketDateFromBack=$dayOfs->ticket_from_back;
        $this->ticketTimeFromGo=$dayOfs->ticket_time_go;
        $this->ticketTimeFromBack=$dayOfs->ticket_time_back;

        $this->travelDateFromGo=$dayOfs->travel_from_go;
        $this->travelDateFromBack=$dayOfs->travel_from_back;

        $this->headApprov=$dayOfs->head_approv;
        $this->hrdApprov=$dayOfs->hrd_approv;
        $this->smApprov=$dayOfs->hrd_approv;

        $annualLeaves=AnnualLeave::where('day_of_id',$dayOfs->id)->first();
        if($annualLeaves){
            if($annualLeaves->start!=='' or $annualLeaves->start!=null){
                $this->annualLeaveStart=$annualLeaves->start;
                $this->annualLeaveEnd=$annualLeaves->end;
                $this->annualLeaveLess=$annualLeaves->less;
                $this->annualLeaveShould=$annualLeaves->should;
            }else{
                $this->annualLeaveStart=null;
                $this->annualLeaveEnd=null;
                $this->annualLeaveLess=$annualLeaves->less;
            }
        }
        $bigLeaves=BigLeave:: where('day_of_id',$dayOfs->id)->first();
        if($bigLeaves){
            if($bigLeaves->start!=='' or $bigLeaves->start!=null){
                $this->bigLeaveStart=$bigLeaves->start;
                $this->bigLeaveEnd=$bigLeaves->end;
                $this->bigLeaveLess=$bigLeaves->less;
                $this->bigLeaveShould=$bigLeaves->should;
            }else{
                $this->bigLeaveStart=null;
                $this->bigLeaveEnd=null;
            }
        }

        $dayOfStandarts = User::select('c.day_of as day','c.travel_day as travelDay','c.travel_day_ticket as ticketDay','a.name as site','b.name as poh')
        ->join('sites as a', 'a.id', '=', 'users.site_id')
        ->join('pohs as b', 'b.id', '=', 'users.poh_id')
        ->leftjoin('poh_day_ofs as c', function ($join) {
            $join->on('c.site_id', '=', 'a.id')
                ->on('c.poh_id', '=', 'b.id');
            })
        ->where('users.id',$dayOfs->user->id)->first();
        $this->dayOfStandartTravelDay=$dayOfStandarts->travelDay/2;
        $this->dayOfStandartTicketDay=$dayOfStandarts->ticketDay/2;
        if($this->dayOfStandartTicketDay>0){
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

                $this->destinationFromGoTicket=$destinationGoTickets->from;
                $this->destinationToGoTicket=$destinationGoTickets->to;
                $this->destinationFromBackTicket=$destinationBackTickets->from;
                $this->destinationToBackTicket=$destinationBackTickets->to;
        }else{
            $this->destinationFromGoTicket=null;
            $this->destinationToGoTicket=null;
            $this->destinationFromBackTicket=null;
            $this->destinationToBackTicket=null;
        }

        if($this->dayOfStandartTravelDay>0){

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
                      
            $this->destinationFromGoTravel=$destinationGoTravels->from;
            $this->destinationToGoTravel=$destinationGoTravels->to; 
            $this->destinationFromBackTravel=$destinationBackTravels->from;
            $this->destinationToBackTravel=$destinationBackTravels->to; 
        }
        else{
            $this->destinationFromGoTravel=null;
            $this->destinationToGoTravel=null; 
            $this->destinationFromBackTravel=null;
            $this->destinationToBackTravel=null; 
        }
        $this->emit('showModal','detailModal');
    }


    public function render(){
        $approvalRecords=ApprovalRecord::select('a.head_approv','a.hrd_approv','a.sm_approv','a.approv','b.level as employeeLevel','c.level as level_approv','c.nrp','c.name as approver','c.hr_head','approval_records.level as level_order','approval_records.reason','approval_records.created_at')
        ->leftjoin('day_ofs as a', 'a.id', '=', 'approval_records.doc')
        ->join('users as b', 'b.id', '=', 'a.user_id')  
        ->leftjoin('users as c', 'c.id', '=', 'approval_records.user_id')        
        ->where('approval_records.doc',$this->dayOfId)->where('approval_records.type','cuti')->get();       
        return view('livewire.transaction.day-of.detail', compact('approvalRecords'));
    }

    private function initializedProperties(){
        $this->employeeId=null;
        $this->dayOfId=null;
        $this->nrp=null;
        $this->name=null;
        $this->position=null;
        $this->department=null;
        $this->site=null;
        $this->address=null;
        $this->phone=null;
        $this->start=null;
        $this->end=null;
        $this->in=null;
        $this->dayOfSum=null;
        $this->inBefore=null;
        $this->workDay=null;

        $this->annualLeaveStart=null;
        $this->annualLeaveEnd=null;
        $this->annualLeaveLess=null;
        $this->annualLeaveShould=null;

        $this->bigLeaveStart=null;
        $this->bigLeaveEnd=null;
        $this->bigLeaveLess=null;
        $this->bigLeaveShould=null;

        $this->destinationFromGoTicket=null;
        $this->destinationToGoTicket=null;
        $this->destinationFromBackTicket=null;
        $this->destinationToBackTicket=null;
        $this->destinationFromGoTravel=null;
        $this->destinationToGoTravel=null; 
        $this->destinationFromBackTravel=null;
        $this->destinationToBackTravel=null; 


        $this->ticketDateFromGo=null;
        $this->ticketDateFromBack=null;
        $this->ticketTimeFromGo=null;
        $this->ticketTimeFromBack=null;

        $this->travelDateFromGo=null;
        $this->travelDateFromBack=null;


        $this->dayOfStandartTravelDay=null;
        $this->dayOfStandartTicketDay=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
        $this->emit('closeModal','detailModal');
    }
}
