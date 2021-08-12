<?php

namespace App\Http\Livewire\Transaction\Assignment;

use Livewire\Component;
use App\Models\Assignment;
use App\Models\AssignmentDestination;
use App\Models\ApprovalRecord;
class Detail extends Component
{
    public $assignmentId;
    public $employeeId;
    public $site;
    public $nrp;
    public $name;
    public $position;
    public $department;
    public $address;
    public $phone;
    public $number;
    public $startDate;
    public $endDate;
    public $inDate;
    public $sumDay;
    public $location;
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

    public function mount($id){
        $assignments=Assignment::find($id);
        $this->assignmentId=$assignments->id;
        $this->employeeId=$assignments->user_id;
        $this->site=$assignments->site->name;
        $this->nrp=$assignments->user->nrp;
        $this->name=$assignments->user->name;
        $this->position=$assignments->user->position->name;
        $this->department=$assignments->user->position->department->name;
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

        if($assignments->location=='oinRegional' or $assignments->location=='outRegional'){
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

        $this->initializedProperties();
    }
    
    public function render(){
        $approvalRecords=ApprovalRecord::select('b.level as employeeLevel','a.head_approv','a.hrd_approv','a.sm_approv','a.approv','c.level as level_approv','c.nrp','c.name as approver','c.hr_head','approval_records.level as level_order','approval_records.reason','approval_records.created_at')
        ->leftjoin('assignments as a', 'a.id', '=', 'approval_records.doc')
        ->join('users as b', 'b.id', '=', 'a.user_id')  
        ->leftjoin('users as c', 'c.id', '=', 'approval_records.user_id')
        ->where('approval_records.doc',$this->assignmentId)->where('approval_records.type','dinas')->get(); 
        return view('livewire.transaction.assignment.detail',compact('approvalRecords'))->extends('layouts.app')->section('content');
    }

    private function initializedProperties(){
        $this->assignmentId;
        $this->employeeId;
        $this->site;
        $this->nrp;
        $this->name;
        $this->position;
        $this->department;
        $this->address;
        $this->phone;
        $this->number;
        $this->startDate;
        $this->endDate;
        $this->inDate;
        $this->sumDay;
        $this->location;
        $this->ticketDateFromGo;
        $this->ticketDateFromBack;
        $this->ticketTimeGo;
        $this->ticketTimeBack;
        $this->travelDateFromGo;
        $this->travelDateFromBack;
        $this->description;
        $this->lodgingCost;
        $this->transportCost;
        $this->mealCost;
        $this->otherCost;
        $this->lodgingDay;
        $this->transportDay;
        $this->mealDay;
        $this->otherDay;

        $this->lodgingCostTotal;
        $this->transportCostTotal;
        $this->mealCostTotal;
        $this->otherCostTotal;
        $this->costGrandTotal;
        $this->countedGrandTotal;

        $this->destinationFromGoTicket;
        $this->destinationToGoTicket;
        $this->destinationFromBackTicket;
        $this->destinationToBackTicket;
        $this->destinationFromGoTravel;
        $this->destinationToGoTravel; 
        $this->destinationFromBackTravel;
        $this->destinationToBackTravel; 
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
        $this->emit('closeModal','modal_detail_assignment');
    }
}
