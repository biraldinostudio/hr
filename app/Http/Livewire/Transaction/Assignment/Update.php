<?php

namespace App\Http\Livewire\Transaction\Assignment;

use App\Models\Destination;
use Livewire\Component;
use App\Models\Assignment;
use App\Models\AssignmentDestination;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
class Update extends Component{
    
    public $assignmentId;

    public $location;

    public $startDateInSite='';
    public $endDateInSite='';
    public $descriptionInSite='';
    public $mealInSiteDay='';
    public $mealInSiteCost='';
    public $otherInSiteDay='';
    public $otherInSiteCost='';

    //Bagian In Region
    public $startDateInReg='';
    public $endDateInReg='';
    public $descriptionInReg='';
    public $onSiteDate='';

    public $travelDestiInRegFromGo='';
    public $travelDestiInRegToGo='';
    public $travelDateInRegFromGo='';
    public $travelDestiInRegFromBack='';
    public $travelDestiInRegToBack='';
    public $travelDateInRegFromBack='';

    public $lodgingInRegDay='';
    public $lodgingInRegCost='';
    public $transportInRegDay='';
    public $transportInRegCost='';
    public $mealInRegDay='';
    public $mealInRegCost='';
    public $otherInRegDay='';
    public $otherInRegCost='';

    //Bagian OutRegion
    public $startDateOutReg='';
    public $endDateOutReg='';
    public $descriptionOutReg='';

    public $ticketDestiOutRegFromGo='';
    public $ticketDestiOutRegToGo='';
    public $ticketDateOutRegFromGo='';
    public $ticketTimeOutRegGo='';
    public $ticketDestiOutRegFromBack='';
    public $ticketDestiOutRegToBack='';
    public $ticketDateOutRegFromBack='';
    public $ticketTimeOutRegBack='';

    public $travelDestiOutRegFromGo='';
    public $travelDestiOutRegToGo='';
    public $travelDateOutRegFromGo='';
    public $travelDestiOutRegFromBack='';
    public $travelDestiOutRegToBack='';
    public $travelDateOutRegFromBack='';

    public $lodgingOutRegDay='';
    public $lodgingOutRegCost='';
    public $transportOutRegDay='';
    public $transportOutRegCost='';
    public $mealOutRegDay='';
    public $mealOutRegCost='';
    public $otherOutRegDay='';
    public $otherOutRegCost='';

    public $addDay=1;
    public $addDayTwo=2;
    public $addDayFive=5;

    //BAGIAN VALIDASI
    public $startDateInSiteValid;
    public $endDateInSiteValid;
    public $descriptionInSiteValid;
    
    public $startDateInRegValid;
    public $endDateInRegValid;
    public $descriptionInRegValid;
    public $travelDestiInRegFromGoValid;
    public $travelDestiInRegToGoValid;
    public $travelDestiInRegFromBackValid;
    public $travelDestiInRegToBackValid;
    public $travelDateInRegFromGoValid;
    public $travelDateInRegFromBackValid;
    public $lodgingInRegDayValid;
    public $transportInRegDayValid;
    public $mealInRegDayValid;
    public $otherInRegDayValid;
    public $lodgingInRegCostValid;
    public $transportInRegCostValid;
    public $mealInRegCostValid;
    public $otherInRegCostValid;
    
    public $startDateOutRegValid;
    public $endDateOutRegValid;
    public $descriptionOutRegValid;
               
    public $ticketDestiOutRegFromGoValid;
    public $ticketDestiOutRegToGoValid;
    public $ticketDestiOutRegFromBackValid;
    public $ticketDestiOutRegToBackValid;
    public $ticketDateOutRegFromGoValid;
    public $ticketDateOutRegFromBackValid;
    public $ticketTimeOutRegGoValid;
    public $ticketTimeOutRegBackValid;
    public $travelDestiOutRegFromGoValid;
    public $travelDestiOutRegToGoValid;
    public $travelDestiOutRegFromBackValid;
    public $travelDestiOutRegToBackValid;
    public $travelDateOutRegFromGoValid;
    public $travelDateOutRegFromBackValid;
    public $lodgingOutRegDayValid;
    public $transportOutRegDayValid;
    public $mealOutRegDayValid;
    public $otherOutRegDayValid;
    public $lodgingOutRegCostValid;
    public $transportOutRegCostValid;
    public $mealOutRegCostValid;
    public $otherOutRegCostValid;

    protected $listeners = [
        'updateAssignment'=>'showModal',
        'selectLocation'=>'getSelectLocation',
        'selectStartDateInSite'=>'getSelectStartDateInSite',
        'selectEndDateInSite'=>'getSelectEndDateInSite',
        'selectStartDateInReg'=>'getSelectStartDateInReg',
        'selectEndDateInReg'=>'getSelectEndDateInReg',
        'selectStartDateOutReg'=>'getSelectStartDateOutReg',
        'selectEndDateOutReg'=>'getSelectEndDateOutReg',

        'selectTravelDestiInRegFromGo'=>'getSelectTravelDestiInRegFromGo',
        'selectTravelDestiInRegToGo'=>'getSelectTravelDestiInRegToGo',
        'selectTravelDateInRegFromGo'=>'getSelectTravelDateInRegFromGo',
        'selectTravelDestiInRegFromBack'=>'getSelectTravelDestiInRegFromBack',
        'selectTravelDestiInRegToBack'=>'getSelectTravelDestiInRegToBack',
        'selectTravelDateInRegFromBack'=>'getSelectTravelDateInRegFromBack',

        'selectTicketDestiOutRegFromGo'=>'getSelectTicketDestiOutRegFromGo',
        'selectTicketDestiOutRegToGo'=>'getSelectTicketDestiOutRegToGo',
        'selectTicketDateOutRegFromGo'=>'getSelectTicketDateOutRegFromGo',
        'selectTicketTimeOutRegGo'=>'getSelectTicketTimeOutRegGo',
        'selectTicketDestiOutRegFromBack'=>'getSelectTicketDestiOutRegFromBack',
        'selectTicketDestiOutRegToBack'=>'getSelectTicketDestiOutRegToBack',
        'selectTicketDateOutRegFromBack'=>'getSelectTicketDateOutRegFromBack',
        'selectTicketTimeOutRegBack'=>'getSelectTicketTimeOutRegBack',
        'selectTravelDestiOutRegFromGo'=>'getSelectTravelDestiOutRegFromGo',
        'selectTravelDestiOutRegToGo'=>'getSelectTravelDestiOutRegToGo',
        'selectTravelDateOutRegFromGo'=>'getSelectTravelDateOutRegFromGo',
        'selectTravelDestiOutRegFromBack'=>'getSelectTravelDestiOutRegFromBack',
        'selectTravelDestiOutRegToBack'=>'getSelectTravelDestiOutRegToBack',
        'selectTravelDateOutRegFromBack'=>'getSelectTravelDateOutRegFromBack',
        'selectOnSiteDate'=>'getSelectOnSiteDate',
    ];

    protected $validationAttributes = [
        'startDateInSite'=>'Tgl mulai tugas/training',
        'endDateInSite'=>'Tgl akhir tugas/training',
        'descriptionInSite'=>'Keperluan tugas/training',
        'mealInSiteDay'=>'Jml hari makan',
        'mealInSiteCost'=>'Biaya makan perhari',
        'otherInSiteDay'=>'Jml hari lain2',
        'otherInSiteCost'=>'Biaya lain2 perhari',

        //IN REG
        'startDateInReg'=>'Tgl mulai tugas/training',
        'endDateInReg'=>'Tgl akhir tugas/training',
        'descriptionInReg'=>'Keperluan tugas/training',
        //Travel In Reg
        'travelDestiInRegFromGo'=>'Travel keberangkatan tugas/training',
        'travelDestiInRegToGo'=>'Travel tujuan  tugas/training',
        'travelDateInRegFromGo'=>'Tgl travel keberangkatan  tugas/training',
        'travelDestiInRegFromBack'=>'Travel keberangkatan kembali ke site',
        'travelDestiInRegToBack'=>'Travel tujuan kembali ke site',
        'travelDateInRegFromBack'=>'Tgl travel kembali ke site',

        'lodgingInRegDay'=>'Jml hari penginapan',
        'lodgingInRegCost'=>'Biaya penginapan perhari',
        'transportInRegDay'=>'Jml hari transportasi',
        'transportInRegCost'=>'Biaya transport perhari',
        'mealInRegDay'=>'Jml hari makan',
        'mealInRegCost'=>'Biaya makan perhari',
        'otherInRegDay'=>'Jml hari lain2',
        'otherInRegCost'=>'Biaya lain2 perhari',

        //OUT REG
        'startDateOutReg'=>'Tgl mulai tugas/training',
        'endDateOutReg'=>'Tgl akhir tugas/training',
        'descriptionOutReg'=>'Keperluan tugas/training',
        //Ticket Out Reg
        'ticketDestiOutRegFromGo'=>'Tiket asal keberangkatan tugas/training',
        'ticketDestiOutRegToGo'=>'Tiket tujuan keberangkatan tugas/training',
        'ticketDestiOutRegFromBack'=>'Tiket asal keberangkatan kembali ke site',
        'ticketDestiOutRegToBack'=>'Tiket tujuan kembali ke site',
        'ticketDateOutRegFromGo'=>'Tgl tiket keberangkatan tugas/training',
        'ticketDateOutRegFromBack'=>'Tgl tiket kembali ke site',
        'ticketTimeOutRegGo'=>'Jam tiket keberangkatan tugas/training',
        'ticketTimeOutRegBack'=>'Jam tiket keberangkatan kembali ke site',
        //Travel Out Reg
        'travelDestiOutRegFromGo'=>'Travel keberangkatan tugas/training',
        'travelDestiOutRegToGo'=>'Travel tujuan  tugas/training',
        'travelDateOutRegFromGo'=>'Tgl travel keberangkatan  tugas/training',
        'travelDestiOutRegFromBack'=>'Travel keberangkatan kembali ke site',
        'travelDestiOutRegToBack'=>'Travel tujuan kembali ke site',
        'travelDateOutRegFromBack'=>'Tgl travel kembali ke site',

        'lodgingOutRegDay'=>'Jml hari penginapan',
        'lodgingOutRegCost'=>'Biaya penginapan perhari',
        'transportOutRegDay'=>'Jml hari transportasi',
        'transportOutRegCost'=>'Biaya transport perhari',
        'mealOutRegDay'=>'Jml hari makan',
        'mealOutRegCost'=>'Biaya makan perhari',
        'otherOutRegDay'=>'Jml hari lain2',
        'otherOutRegCost'=>'Biaya lain2 perhari',
    ];

    public function updated($property, $value){
        
        if(trim($value)){
            $this->validateOnly($property);
        }else{
            $this->resetErrorBag($property);
        }
    }

    public function mount($id){
        $assignments=Assignment::find($id);
        $this->assignmentId=$assignments->id;
        $this->employeeId=$assignments->user_id;
        $this->site=$assignments->site_id;
        $this->number=$assignments->number;
        $this->location=$assignments->location;
        if($this->location=='inSite'){
            $this->startDateInSite=date('d/m/Y',strtotime($assignments->start_date));
            $this->endDateInSite=date('d/m/Y',strtotime($assignments->end_date));
            $this->onSiteDate=date('d/m/Y',strtotime($assignments->in_date));
            $this->descriptionInSite=$assignments->description;
            $this->mealInSiteCost=currency_IDR($assignments->meal_cost);
            $this->otherInSiteCost=currency_IDR($assignments->other_cost);
            $this->mealInSiteDay=$assignments->meal_day;
            $this->otherInSiteDay=$assignments->other_day;
        }

        if($this->location=='inRegional'){
            $this->startDateInReg=date('d/m/Y',strtotime($assignments->start_date));
            $this->endDateInReg=date('d/m/Y',strtotime($assignments->end_date));
            $this->onSiteDate=date('d/m/Y',strtotime($assignments->in_date));
            $this->travelDateInRegFromGo=date('d/m/Y',strtotime($assignments->travel_date_from_go));
            $this->travelDateInRegFromBack=date('d/m/Y',strtotime($assignments->travel_date_from_back));
            $this->descriptionInReg=$assignments->description;
            $this->lodgingInRegCost=currency_IDR($assignments->lodging_cost);
            $this->transportInRegCost=currency_IDR($assignments->transportation_cost);
            $this->mealInRegCost=currency_IDR($assignments->meal_cost);
            $this->otherInRegCost=currency_IDR($assignments->other_cost);
            $this->lodgingInRegDay=$assignments->lodging_day;
            $this->transportInRegDay=$assignments->transportation_day;
            $this->mealInRegDay=$assignments->meal_day;
            $this->otherInRegDay=$assignments->other_day;

            $travelDestiInRegGos=AssignmentDestination::where('assignment_id',$assignments->id)->where('type','Go')->where('destination','Travel')->first();
            $travelDestiInRegBacks=AssignmentDestination::where('assignment_id',$assignments->id)->where('type','Back')->where('destination','Travel')->first();

            $this->travelDestiInRegFromGo=$travelDestiInRegGos->from_id;
            $this->travelDestiInRegToGo=$travelDestiInRegGos->to_id;
            $this->travelDestiInRegFromBack=$travelDestiInRegBacks->from_id;
            $this->travelDestiInRegToBack=$travelDestiInRegBacks->to_id;
        }
        if($this->location=='outRegional'){
            $this->startDateOutReg=date('d/m/Y',strtotime($assignments->start_date));
            $this->endDateOutReg=date('d/m/Y',strtotime($assignments->end_date));
            $this->onSiteDate=date('d/m/Y',strtotime($assignments->in_date));
            $this->ticketDateOutRegFromGo=date('d/m/Y',strtotime($assignments->ticket_date_from_go));
            $this->ticketDateOutRegFromBack=date('d/m/Y',strtotime($assignments->ticket_date_from_back));
            $this->ticketTimeOutRegGo=date('H:i',strtotime($assignments->ticket_time_from_go));
            $this->ticketTimeOutRegBack=date('H:i',strtotime($assignments->ticket_time_from_back));
            $this->travelDateOutRegFromGo=date('d/m/Y',strtotime($assignments->travel_date_from_go));
            $this->travelDateOutRegFromBack=date('d/m/Y',strtotime($assignments->travel_date_from_back));
            $this->descriptionOutReg=$assignments->description;
            $this->lodgingOutRegCost=currency_IDR($assignments->lodging_cost);
            $this->transportOutRegCost=currency_IDR($assignments->transportation_cost);
            $this->mealOutRegCost=currency_IDR($assignments->meal_cost);
            $this->otherOutRegCost=currency_IDR($assignments->other_cost);
            $this->lodgingOutRegDay=$assignments->lodging_day;
            $this->transportOutRegDay=$assignments->transportation_day;
            $this->mealOutRegDay=$assignments->meal_day;
            $this->otherOutRegDay=$assignments->other_day;

            $ticketDestiOutRegGos=AssignmentDestination::where('assignment_id',$assignments->id)->where('type','Go')->where('destination','Ticket')->first();
            $ticketDestiOutRegBacks=AssignmentDestination::where('assignment_id',$assignments->id)->where('type','Back')->where('destination','Ticket')->first();

            $travelDestiOutRegGos=AssignmentDestination::where('assignment_id',$assignments->id)->where('type','Go')->where('destination','Travel')->first();
            $travelDestiOutRegBacks=AssignmentDestination::where('assignment_id',$assignments->id)->where('type','Back')->where('destination','Travel')->first();

            $this->ticketDestiOutRegFromGo=$ticketDestiOutRegGos->from_id;
            $this->ticketDestiOutRegToGo=$ticketDestiOutRegGos->to_id;
            $this->ticketDestiOutRegFromBack=$ticketDestiOutRegBacks->from_id;
            $this->ticketDestiOutRegToBack=$ticketDestiOutRegBacks->to_id;

            $this->travelDestiOutRegFromGo=$travelDestiOutRegGos->from_id;
            $this->travelDestiOutRegToGo=$travelDestiOutRegGos->to_id;
            $this->travelDestiOutRegFromBack=$travelDestiOutRegBacks->from_id;
            $this->travelDestiOutRegToBack=$travelDestiOutRegBacks->to_id;
        }

        $this->initializedProperties();
    }

    public function render(){
        $destinations=Destination::select('id','name')->where('active','1')->get();
        return view('livewire.transaction.assignment.update',compact('destinations'))->extends('layouts.app')->section('content');
    }
    public function update(){
       //dd($this->assignmentId);
        $this->validate();
        if($this->location=='inSite'){
            $startDateInSiteRep= str_replace('/', '-',$this->startDateInSite);
            $endDateInSiteRep= str_replace('/', '-', $this->endDateInSite);
            $dayOfCalculateInSite=CountDay($startDateInSiteRep,$endDateInSiteRep);
           //$inDateReps= str_replace('/', '-', $this->inDateInSite);
            
        }

        if($this->location=='inRegional'){
            $startDateInRegRep= str_replace('/', '-',$this->startDateInReg);
            $endDateInRegRep= str_replace('/', '-',$this->endDateInReg);
            $travelDateInRegFromGoRep= str_replace('/', '-', $this->travelDateInRegFromGo);
            $travelDateInRegFromBackRep= str_replace('/', '-', $this->travelDateInRegFromBack);
            $dayOfCalculateInReg=CountDay($startDateInRegRep,$endDateInRegRep);
           // $inDateReps= str_replace('/', '-', $this->inDateInReg);
        }

        if($this->location=='outRegional'){
            $startDateOutRegRep= str_replace('/', '-',$this->startDateOutReg);
            $endDateOutRegRep= str_replace('/', '-',$this->endDateOutReg);
            $ticketDateOutRegFromGoRep= str_replace('/', '-',$this->ticketDateOutRegFromGo);
            $ticketDateOutRegFromBackRep= str_replace('/', '-',$this->ticketDateOutRegFromBack);
            $travelDateOutRegFromGoRep= str_replace('/', '-',$this->travelDateOutRegFromGo);
            $travelDateOutRegFromBackRep= str_replace('/', '-',$this->travelDateOutRegFromBack);
            $dayOfCalculateOutReg=CountDay($startDateOutRegRep,$endDateOutRegRep);
            //$inDateReps= str_replace('/', '-', $this->inDateOutReg);
        }
       $onSiteDateRep= str_replace('/', '-',$this->onSiteDate);
       DB::beginTransaction();
        try{
		    if($this->location=='inSite'){
                $assignments = Assignment::whereId($this->assignmentId)->first();
				$assignments->start_date = date('Y-m-d', strtotime($startDateInSiteRep));
				$assignments->end_date = date('Y-m-d', strtotime($endDateInSiteRep));
				$assignments->in_date = date('Y-m-d', strtotime($onSiteDateRep));
				$assignments->sum_day=$dayOfCalculateInSite + $this->addDay;
				$assignments->description=trim($this->descriptionInSite);
                $assignments->location=$this->location;
				$assignments->ticket_date_from_go=null;
				$assignments->ticket_date_from_back=null;
				$assignments->ticket_time_from_go=null;
				$assignments->ticket_time_from_back=null;
				$assignments->travel_date_from_go=null;
				$assignments->travel_date_from_back=null;
				$assignments->lodging_cost=null;
				$assignments->transportation_cost=null;
                $assignments->meal_cost =currencyIDRToNumeric($this->mealInSiteCost);
				$assignments->other_cost =currencyIDRToNumeric($this->otherInSiteCost);
				$assignments->lodging_day=null;
				$assignments->transportation_day=null;
				$assignments->meal_day =$this->mealInSiteDay;	
				$assignments->other_day =$this->otherInSiteDay;
				$assignments->save();

                $checkDestiTicketTravels=AssignmentDestination::where('assignment_id',$this->assignmentId)->count();
                if($checkDestiTicketTravels>0){
                    AssignmentDestination::where('assignment_id',$this->assignmentId)->delete();
                }
              
			}
			if($this->location=='inRegional'){
                $assignments = Assignment::whereId($this->assignmentId)->first();
				$assignments->start_date = date('Y-m-d', strtotime($startDateInRegRep));
				$assignments->end_date = date('Y-m-d', strtotime($endDateInRegRep));
				$assignments->in_date = date('Y-m-d', strtotime($onSiteDateRep));
				$assignments->sum_day=$dayOfCalculateInReg + $this->addDay;
                $assignments->description=trim($this->descriptionInReg);
                $assignments->location=$this->location;
				$assignments->travel_date_from_go=date('Y-m-d', strtotime($travelDateInRegFromGoRep));
				$assignments->travel_date_from_back=date('Y-m-d', strtotime($travelDateInRegFromBackRep));
				$assignments->ticket_date_from_go=null;
				$assignments->ticket_date_from_back=null;
				$assignments->ticket_time_from_go=null;
				$assignments->ticket_time_from_back=null;
				$assignments->lodging_cost =currencyIDRToNumeric($this->lodgingInRegCost);
				$assignments->transportation_cost =currencyIDRToNumeric($this->transportInRegCost);
				$assignments->meal_cost =currencyIDRToNumeric($this->mealInRegCost);
				$assignments->other_cost =currencyIDRToNumeric($this->otherInRegCost);
				$assignments->lodging_day =$this->lodgingInRegDay;
				$assignments->transportation_day =$this->transportInRegDay;
				$assignments->meal_day =$this->mealInRegDay;	
				$assignments->other_day =$this->otherInRegDay;
				$assignments->save();

                $checkDestiTickets=AssignmentDestination::where('assignment_id',$this->assignmentId)->where('destination','Ticket')->count();
                if($checkDestiTickets>0){
                    AssignmentDestination::where('assignment_id',$this->assignmentId)->where('destination','Ticket')->delete();
                }
                $checkDestiTravels=AssignmentDestination::where('assignment_id',$this->assignmentId)->where('destination','Travel')->count();
                if($checkDestiTravels>0){
                    $travelDestiInRegFromGos = AssignmentDestination::where('assignment_id',$this->assignmentId)->where('type','Go')->where('destination','Travel')->first();
                    $travelDestiInRegFromGos->from_id =$this->travelDestiInRegFromGo;
                    $travelDestiInRegFromGos->to_id =$this->travelDestiInRegToGo;
                    $travelDestiInRegFromGos->save();

                    $travelDestiInRegFromBacks = AssignmentDestination::where('assignment_id',$this->assignmentId)->where('type','Back')->where('destination','Travel')->first();
                    $travelDestiInRegFromBacks->from_id =$this->travelDestiInRegFromBack;
                    $travelDestiInRegFromBacks->to_id =$this->travelDestiInRegToBack;
                    $travelDestiInRegFromBacks->save();
                }else{
                    $data = [
                        ['assignment_id'=>$assignments->id,'from_id'=>$this->travelDestiInRegFromGo, 'to_id'=>$this->travelDestiInRegToGo,'type'=> 'Go','destination'=>'Travel','active'=>'1','created_at'=>date('Y-m-d H:i:s')],
                        ['assignment_id'=>$assignments->id,'from_id'=>$this->travelDestiInRegFromBack,'to_id'=>$this->travelDestiInRegToBack, 'type'=> 'Back','destination'=>'Travel','active'=>'1','created_at'=>date('Y-m-d H:i:s')],
                    ];
                    AssignmentDestination::insert($data);
                }
			}
			if($this->location=='outRegional'){
				$assignments = Assignment::whereId($this->assignmentId)->first();
				$assignments->start_date = date('Y-m-d', strtotime($startDateOutRegRep));
				$assignments->end_date = date('Y-m-d', strtotime($endDateOutRegRep));
				$assignments->in_date = date('Y-m-d', strtotime($onSiteDateRep));
				$assignments->sum_day=$dayOfCalculateOutReg + $this->addDay;
				$assignments->ticket_date_from_go=date('Y-m-d', strtotime($ticketDateOutRegFromGoRep));
				$assignments->ticket_date_from_back=date('Y-m-d', strtotime($ticketDateOutRegFromBackRep));
				$assignments->ticket_time_from_go=$this->ticketTimeOutRegGo;
				$assignments->ticket_time_from_back=$this->ticketTimeOutRegBack;
				$assignments->travel_date_from_go=date('Y-m-d', strtotime($travelDateOutRegFromGoRep));
				$assignments->travel_date_from_back=date('Y-m-d', strtotime($travelDateOutRegFromBackRep));
                
				$assignments->description=trim($this->descriptionOutReg);
                $assignments->location=$this->location;
				$assignments->lodging_cost =currencyIDRToNumeric($this->lodgingOutRegCost);
				$assignments->transportation_cost =currencyIDRToNumeric($this->transportOutRegCost);
				$assignments->meal_cost =currencyIDRToNumeric($this->mealOutRegCost);
				$assignments->other_cost =currencyIDRToNumeric($this->otherOutRegCost);
				$assignments->lodging_day =$this->lodgingOutRegDay;
				$assignments->transportation_day =$this->transportOutRegDay;
				$assignments->meal_day =$this->mealOutRegDay;	
				$assignments->other_day =$this->otherOutRegDay;
				$assignments->save();

                
                $checkDestiTickets=AssignmentDestination::where('assignment_id',$this->assignmentId)->where('destination','Ticket')->count();
                if($checkDestiTickets>0){
                    $ticketDestiOutRegFromGos = AssignmentDestination::where('assignment_id',$this->assignmentId)->where('type','Go')->where('destination','Ticket')->first();
                    $ticketDestiOutRegFromGos->from_id =$this->ticketDestiOutRegFromGo;
                    $ticketDestiOutRegFromGos->to_id =$this->ticketDestiOutRegToGo;
                    $ticketDestiOutRegFromGos->save();

                    $ticketDestiOutRegFromBacks = AssignmentDestination::where('assignment_id',$this->assignmentId)->where('type','Back')->where('destination','Ticket')->first();
                    $ticketDestiOutRegFromBacks->from_id =$this->ticketDestiOutRegFromBack;
                    $ticketDestiOutRegFromBacks->to_id =$this->ticketDestiOutRegToBack;
                    $ticketDestiOutRegFromBacks->save();
                }else{
                    $data = [
                        ['assignment_id'=>$assignments->id,'from_id'=>$this->ticketDestiOutRegFromGo, 'to_id'=>$this->ticketDestiOutRegToGo,'type'=> 'Go','destination'=>'Ticket','active'=>'1','created_at'=>date('Y-m-d H:i:s')],
                        ['assignment_id'=>$assignments->id,'from_id'=>$this->ticketDestiOutRegFromBack,'to_id'=>$this->ticketDestiOutRegToBack, 'type'=> 'Back','destination'=>'Ticket','active'=>'1','created_at'=>date('Y-m-d H:i:s')],
                    ];
                    AssignmentDestination::insert($data);
                }

                $checkDestiTravels=AssignmentDestination::where('assignment_id',$this->assignmentId)->where('destination','Travel')->count();
                if($checkDestiTravels>0){
                    $travelDestiOutRegFromGos = AssignmentDestination::where('assignment_id',$this->assignmentId)->where('type','Go')->where('destination','Travel')->first();
                    $travelDestiOutRegFromGos->from_id =$this->travelDestiOutRegFromGo;
                    $travelDestiOutRegFromGos->to_id =$this->travelDestiOutRegToGo;
                    $travelDestiOutRegFromGos->save();

                    $travelDestiOutRegFromBacks = AssignmentDestination::where('assignment_id',$this->assignmentId)->where('type','Back')->where('destination','Travel')->first();
                    $travelDestiOutRegFromBacks->from_id =$this->travelDestiOutRegFromBack;
                    $travelDestiOutRegFromBacks->to_id =$this->travelDestiOutRegToBack;
                    $travelDestiOutRegFromBacks->save();
                }else{
                    $data = [
                        ['assignment_id'=>$assignments->id,'from_id'=>$this->travelDestiOutRegFromGo, 'to_id'=>$this->travelDestiOutRegToGo,'type'=> 'Go','destination'=>'Travel','active'=>'1','created_at'=>date('Y-m-d H:i:s')],
                        ['assignment_id'=>$assignments->id,'from_id'=>$this->travelDestiOutRegFromBack,'to_id'=>$this->travelDestiOutRegToBack, 'type'=> 'Back','destination'=>'Travel','active'=>'1','created_at'=>date('Y-m-d H:i:s')],
                    ];
                    AssignmentDestination::insert($data);
                }
			}
           
            $this->emit('refreshDropdown');
            session()->flash('message', 'Berhasil ubah data!');
            $this->initializedProperties();
           redirect()->route('my-assignment');
        }catch(\Throwable $th){
            DB::rollBack();
          $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Ubah Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
        }
        DB::commit();
    }

    private function initializedProperties(){
        $this->assignmentId;
        $this->location;
        $this->startDateInSite;
        $this->endDateInSite;
        $this->descriptionInSite;
        $this->mealInSiteDay;
        $this->mealInSiteCost;
        $this->otherInSiteDay;
        $this->otherInSiteCost;

        $this->onSiteDate;

        //Bagian In Region
        $this->startDateInReg;
        $this->endDateInReg;
        $this->descriptionInReg;

        $this->travelDestiInRegFromGo;
        $this->travelDestiInRegToGo;
        $this->travelDateInRegFromGo;
        $this->travelDestiInRegFromBack;
        $this->travelDestiInRegToBack;
        $this->travelDateInRegFromBack;

        $this->lodgingInRegDay;
        $this->lodgingInRegCost;
        $this->transportInRegDay;
        $this->transportInRegCost;
        $this->mealInRegDay;
        $this->mealInRegCost;
        $this->otherInRegDay;
        $this->otherInRegCost;
        //Bagian OutRegion
        $this->startDateOutReg;
        $this->endDateOutReg;
        $this->descriptionOutReg;

        $this->ticketDestiOutRegFromGo;
        $this->ticketDestiOutRegToGo;
        $this->ticketDateOutRegFromGo;
        $this->ticketTimeOutRegGo;
        $this->ticketDestiOutRegFromBack;
        $this->ticketDestiOutRegToBack;
        $this->ticketDateOutRegFromBack;
        $this->ticketTimeOutRegBack;

        $this->travelDestiOutRegFromGo;
        $this->travelDestiOutRegToGo;
        $this->travelDateOutRegFromGo;
        $this->travelDestiOutRegFromBack;
        $this->travelDestiOutRegToBack;
        $this->travelDateOutRegFromBack;

        $this->lodgingOutRegDay;
        $this->lodgingOutRegCost;
        $this->transportOutRegDay;
        $this->transportOutRegCost;
        $this->mealOutRegDay;
        $this->mealOutRegCost;
        $this->otherOutRegDay;
        $this->otherOutRegCost;
        
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
        $this->emit('closeModal','modal_update_assignment');
    }

    public function getSelectLocation($value){
            $this->location=$value;
    }

    public function getSelectStartDateInSite($value){
        $this->startDateInSite=$value;
        if($this->startDateInSite!=null){
            $this->endDateInSite=date('d/m/Y', strtotime(str_replace('/', '-',$this->startDateInSite).'+'.$this->addDay.' days'));
            $this->onSiteDate = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateInSite).'+'.$this->addDay.' days'));
        }else{
            $this->endDateInSite=$this->startDateInSite;
            $this->onSiteDate=$this->startDateInSite;
        }
    }

    public function getSelectEndDateInSite($value){
        $this->endDateInSite=$value;
        if($this->endDateInSite!=null){
            $this->onSiteDate = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateInSite).'+'.$this->addDay.' days'));
            
        }else{
            $this->startDateInSite=$this->endDateInSite;
            $this->onSiteDate=$this->endDateInSite;
        }
    }

    //BAGIAN IN REGION
    public function getSelectStartDateInReg($value){
        $this->startDateInReg=$value;
        if($this->startDateInReg!=null){
            $this->endDateInReg=date('d/m/Y', strtotime(str_replace('/', '-',$this->startDateInReg).'+'.$this->addDay.' days'));
            $this->travelDateInRegFromGo = date('d/m/Y', strtotime(str_replace('/', '-',$this->startDateInReg)));
            $this->travelDateInRegFromBack = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateInReg)));
            $this->onSiteDate = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateInReg).'+'.$this->addDay.' days'));
        }else{
            $this->endDateInReg=$this->startDateInReg;
            $this->travelDateInRegFromGo=$this->startDateInReg;
            $this->travelDateInRegFromBack=$this->startDateInReg;
            $this->onSiteDate=$this->startDateInReg;
        }
    }

    public function getSelectEndDateInReg($value){
        $this->endDateInReg=$value;
        if($this->endDateInReg!=null){
            $this->onSiteDate = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateInReg).'+'.$this->addDay.' days'));
            $this->travelDateInRegFromBack = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateInReg)));
            $this->onSiteDate = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateInReg).'+'.$this->addDay.' days'));
            
        }else{
            $this->startDateInReg=$this->endDateInReg;
            $this->travelDateInRegFromGo=$this->endDateInReg;
            $this->travelDateInRegFromBack=$this->endDateInReg;
            $this->onSiteDate=$this->endDateInReg;
        }
    }

    public function getSelectTravelDestiInRegFromGo($value){
        $this->travelDestiInRegFromGo=$value;
    }

    public function getSelectTravelDestiInRegToGo($value){
        $this->travelDestiInRegToGo=$value;
    }

    public function getSelectTravelDateInRegFromGo($value){
        $this->travelDateInRegFromGo=$value;
    }

    public function getSelectTravelDestiInRegFromBack($value){
        $this->travelDestiInRegFromBack=$value;
    }

    public function getSelectTravelDestiInRegToBack($value){
        $this->travelDestiInRegToBack=$value;
    }

    public function getSelectTravelDateInRegFromBack($value){
        $this->travelDateInRegFromBack=$value;
    }

    //BAGIAn OUT REGION

    public function getSelectStartDateOutReg($value){
        $this->startDateOutReg=$value;
        if($this->startDateOutReg!=null){
            $this->endDateOutReg=date('d/m/Y', strtotime(str_replace('/', '-',$this->startDateOutReg).'+'.$this->addDayFive.' days'));
            $this->travelDateOutRegFromGo = date('d/m/Y', strtotime(str_replace('/', '-',$this->startDateOutReg))); 
            $this->travelDateOutRegFromBack = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateOutReg)));
            $this->ticketDateOutRegFromGo = date('d/m/Y', strtotime(str_replace('/', '-',$this->startDateOutReg).'+'.$this->addDay.' days'));  
            $this->ticketDateOutRegFromBack = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateOutReg).'-'.$this->addDay.' days')); 
            $this->onSiteDate = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateOutReg).'+'.$this->addDay.' days'));
        }else{
            $this->endDateOutReg=$this->startDateOutReg;
            $this->travelDateOutRegFromGo=$this->startDateOutReg;
            $this->travelDateOutRegFromBack=$this->startDateOutReg;
            $this->ticketDateOutRegFromGo=$this->startDateOutReg;
            $this->ticketDateOutRegFromBack=$this->startDateOutReg;
            $this->onSiteDate=$this->startDateOutReg;
        }
    }

    public function getSelectEndDateOutReg($value){
        $this->endDateOutReg=$value;
        if($this->endDateOutReg!=null){
            $this->travelDateOutRegFromGo = date('d/m/Y', strtotime(str_replace('/', '-',$this->startDateOutReg))); 
            $this->travelDateOutRegFromBack = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateOutReg)));
            $this->ticketDateOutRegFromGo = date('d/m/Y', strtotime(str_replace('/', '-',$this->startDateOutReg).'+'.$this->addDay.' days'));  
            $this->ticketDateOutRegFromBack = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateOutReg).'-'.$this->addDay.' days')); 
            $this->onSiteDate = date('d/m/Y', strtotime(str_replace('/', '-',$this->endDateOutReg).'+'.$this->addDay.' days'));
        }else{
            $this->startDateOutReg=$this->endDateOutReg;
            $this->travelDateOutRegFromGo=$this->endDateOutReg;
            $this->travelDateOutRegFromBack=$this->endDateOutReg;
            $this->ticketDateOutRegFromGo=$this->endDateOutReg;
            $this->ticketDateOutRegFromBack=$this->endDateOutReg;
            $this->onSiteDate=$this->endDateOutReg;
        }
    }

    public function getSelectTicketDestiOutRegFromGo($value){
        $this->ticketDestiOutRegFromGo=$value;
    }

    public function getSelectTicketDestiOutRegToGo($value){
        $this->ticketDestiOutRegToGo=$value;
    }

    public function getSelectTicketDateOutRegFromGo($value){
        $this->ticketDateOutRegFromGo=$value;
    }

    public function getSelectTicketTimeOutRegGo($value){
        $this->ticketTimeOutRegGo=$value;
    }

    public function getSelectTicketDestiOutRegFromBack($value){
        $this->ticketDestiOutRegFromBack=$value;
    }

    public function getSelectTicketDestiOutRegToBack($value){
        $this->ticketDestiOutRegToBack=$value;
    }

    public function getSelectTicketDateOutRegFromBack($value){
        $this->ticketDateOutRegFromBack=$value;
    }

    public function getSelectTicketTimeOutRegBack($value){
        $this->ticketTimeOutRegBack=$value;
    }

    public function getSelectTravelDestiOutRegFromGo($value){
        $this->travelDestiOutRegFromGo=$value;
    }

    public function getSelectTravelDestiOutRegToGo($value){
        $this->travelDestiOutRegToGo=$value;
    }

    public function getSelectTravelDateOutRegFromGo($value){
        $this->travelDateOutRegFromGo=$value;
    }

    public function getSelectTravelDestiOutRegFromBack($value){
        $this->travelDestiOutRegFromBack=$value;
    }

    public function getSelectTravelDestiOutRegToBack($value){
        $this->travelDestiOutRegToBack=$value;
    }

    public function getSelectTravelDateOutRegFromBack($value){
        $this->travelDateOutRegFromBack=$value;
    }

    public function getSelectOnSiteDate($value) {
        $this->onSiteDate=$value;
    }

    public function rules (){
        if($this->location=='inSite'){
           $this->startDateInSiteValid='required|date_format:"d/m/Y"|after:'.date("d/m/Y");
           $this->endDateInSiteValid='required|date_format:"d/m/Y"|after_or_equal:endDateInSite';
           $this->descriptionInSiteValid='required|min:10|max:200';
           $this->mealInSiteDayValid='required|numeric|digits_between:1,2|not_in:0';
           $this->otherInSiteDayValid='required|numeric|digits_between:1,2|not_in:0';
           $this->mealInSiteCostValid='required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/';
           $this->otherInSiteCostValid='required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/';	
        }else{
            $this->startDateInSiteValid='nullable';
            $this->endDateInSiteValid='nullable';
            $this->descriptionInSiteValid='nullable';
            $this->mealInSiteDayValid='nullable';
            $this->otherInSiteDayValid='nullable';
            $this->mealInSiteCostValid='nullable';
            $this->otherInSiteCostValid='nullable';
        }
        
        if($this->location=='inRegional'){
            $this->startDateInRegValid='required|date_format:"d/m/Y"|after:'.date("d/m/Y");
            $this->endDateInRegValid='required|date_format:"d/m/Y"|after_or_equal:startDateInReg';
            $this->descriptionInRegValid='required|min:10|max:200';
            $this->travelDestiInRegFromGoValid='required';
            $this->travelDestiInRegToGoValid='required|different:travelDestiInRegFromGo';
            $this->travelDestiInRegFromBackValid='required|different:travelDestiInRegFromGo';
            $this->travelDestiInRegToBackValid='required|different:travelDestiInRegFromBack|different:travelDestiInRegToGo';
            $this->travelDateInRegFromGoValid='required|date_format:"d/m/Y"|after:'.date("d/m/Y").'|same:startDateInReg';
            $this->travelDateInRegFromBackValid='required|date_format:"d/m/Y"|after_or_equal:startDateInReg|same:endDateInReg';			
            $this->lodgingInRegDayValid='required|numeric|digits_between:1,2|not_in:0';
            $this->transportInRegDayValid='required|numeric|digits_between:1,2|not_in:0';
            $this->mealInRegDayValid='required|numeric|digits_between:1,2|not_in:0';
            $this->otherInRegDayValid='required|numeric|digits_between:1,2|not_in:0';
            $this->lodgingInRegCostValid='required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/';
            $this->transportInRegCostValid='required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/';
            $this->mealInRegCostValid='required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/';
            $this->otherInRegCostValid='required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/';		
        }else{
            $this->startDateInRegValid='nullable';
            $this->endDateInRegValid='nullable';
            $this->descriptionInRegValid='nullable';
            $this->travelDestiInRegFromGoValid='nullable';
            $this->travelDestiInRegToGoValid='nullable';
            $this->travelDestiInRegFromBackValid='nullable';
            $this->travelDestiInRegToBackValid='nullable';
            $this->travelDateInRegFromGoValid='nullable';
            $this->travelDateInRegFromBackValid='nullable';			
            $this->lodgingInRegDayValid='nullable';
            $this->transportInRegDayValid='nullable';
            $this->mealInRegDayValid='nullable';
            $this->otherInRegDayValid='nullable';
            $this->lodgingInRegCostValid='nullable';
            $this->transportInRegCostValid='nullable';
            $this->mealInRegCostValid='nullable';
            $this->otherInRegCostValid='nullable';	
        }
        
        if($this->location=='outRegional'){
            $this->startDateOutRegValid='required|date_format:"d/m/Y"|after:'.date("d/m/Y");
            $this->endDateOutRegValid='required|date_format:"d/m/Y"|after:ticketDateOutRegFromBack';
            $this->descriptionOutRegValid='required|min:10|max:200';
            
            $this->ticketDestiOutRegFromGoValid='required';
            $this->ticketDestiOutRegToGoValid='required|different:ticketDestiOutRegFromGo';
            $this->ticketDestiOutRegFromBackValid='required|different:ticketDestiOutRegFromGo';
            $this->ticketDestiOutRegToBackValid='required|different:ticketDestiOutRegFromBack|different:ticketDestiOutRegToGo';
            $this->ticketDateOutRegFromGoValid='required|date_format:"d/m/Y"|after:'.date("d/m/Y");
            $this->ticketDateOutRegFromBackValid='required|date_format:"d/m/Y"|after:ticketDateOutRegFromGo';
            $this->ticketTimeOutRegGoValid='required|date_format:"H:i"';
            $this->ticketTimeOutRegBackValid='required|date_format:"H:i"';
            $this->travelDestiOutRegFromGoValid='required';
            $this->travelDestiOutRegToGoValid='required|different:travelDestiOutRegFromGo';
            $this->travelDestiOutRegFromBackValid='required|different:travelDestiOutRegFromGo';
            $this->travelDestiOutRegToBackValid='required|different:travelDestiOutRegFromBack|different:travelDestiOutRegToGo';
            $this->travelDateOutRegFromGoValid='required|date_format:"d/m/Y"|after:'.date("d/m/Y").'|same:startDateOutReg';
            $this->travelDateOutRegFromBackValid='required|date_format:"d/m/Y"|after:ticketDateOutRegFromBack|same:endDateOutReg';		
            $this->lodgingOutRegDayValid='required|numeric|digits_between:1,2|not_in:0';
            $this->transportOutRegDayValid='required|numeric|digits_between:1,2|not_in:0';
            $this->mealOutRegDayValid='required|numeric|digits_between:1,2|not_in:0';
            $this->otherOutRegDayValid='required|numeric|digits_between:1,2|not_in:0';
            $this->lodgingOutRegCostValid='required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/';
            $this->transportOutRegCostValid='required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/';
            $this->mealOutRegCostValid='required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/';
            $this->otherOutRegCostValid='required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/';		
        }else{
            $this->startDateOutRegValid='nullable';
            $this->endDateOutRegValid='nullable';
            $this->descriptionOutRegValid='nullable';
            
            $this->ticketDestiOutRegFromGoValid='nullable';
            $this->ticketDestiOutRegToGoValid='nullable';
            $this->ticketDestiOutRegFromBackValid='nullable';
            $this->ticketDestiOutRegToBackValid='nullable';
            $this->ticketDateOutRegFromGoValid='nullable';
            $this->ticketDateOutRegFromBackValid='nullable';
            $this->ticketTimeOutRegGoValid='nullable';
            $this->ticketTimeOutRegBackValid='nullable';
            $this->travelDestiOutRegFromGoValid='nullable';
            $this->travelDestiOutRegToGoValid='nullable';
            $this->travelDestiOutRegFromBackValid='nullable';
            $this->travelDestiOutRegToBackValid='nullable';
            $this->travelDateOutRegFromGoValid='nullable';
            $this->travelDateOutRegFromBackValid='nullable';		
            $this->lodgingOutRegDayValid='nullable';
            $this->transportOutRegDayValid='nullable';
            $this->mealOutRegDayValid='nullable';
            $this->otherOutRegDayValid='nullable';
            $this->lodgingOutRegCostValid='nullable';
            $this->transportOutRegCostValid='nullable';
            $this->mealOutRegCostValid='nullable';
            $this->otherOutRegCostValid='nullable';	
        } 
       return[
           //IN SITE
           'startDateInSite'=>$this->startDateInSiteValid,
           'endDateInSite'=>$this->endDateInSiteValid,
           'descriptionInSite'=>$this->descriptionInSiteValid,
           'mealInSiteDay'=>$this->mealInSiteDayValid,
           'otherInSiteDay'=>$this->otherInSiteDayValid,
           'mealInSiteCost'=>$this->mealInSiteCostValid,
           'otherInSiteCost'=>$this->otherInSiteCostValid,

           //IN REGIONAL
           'startDateInReg'=>$this->startDateInRegValid,
           'endDateInReg'=>$this->endDateInRegValid,
           'descriptionInReg'=>$this->descriptionInRegValid,
           'travelDestiInRegFromGo'=>$this->travelDestiInRegFromGoValid,
           'travelDestiInRegToGo'=>$this->travelDestiInRegToGoValid,
           'travelDestiInRegFromBack'=>$this->travelDestiInRegFromBackValid,
           'travelDestiInRegToBack'=>$this->travelDestiInRegToBackValid,
           'travelDateInRegFromGo'=>$this->travelDateInRegFromGoValid,
           'travelDateInRegFromBack'=>$this->travelDateInRegFromBackValid,
           'lodgingInRegDay'=>$this->lodgingInRegDayValid,
           'transportInRegDay'=>$this->transportInRegDayValid,
           'mealInRegDay'=>$this->mealInRegDayValid,
           'otherInRegDay'=>$this->otherInRegDayValid,
           'lodgingInRegCost'=>$this->lodgingInRegCostValid,
           'transportInRegCost'=>$this->transportInRegCostValid,
           'mealInRegCost'=>$this->mealInRegCostValid,
           'otherInRegCost'=>$this->otherInRegCostValid,
           //OUT REGIONAL
           'startDateOutReg'=>$this->startDateOutRegValid,
           'endDateOutReg'=>$this->endDateOutRegValid,
           'descriptionOutReg'=>$this->descriptionOutRegValid,
           'travelDestiOutRegFromGo'=>$this->travelDestiOutRegFromGoValid,
           'travelDestiOutRegToGo'=>$this->travelDestiOutRegToGoValid,
           'travelDestiOutRegFromBack'=>$this->travelDestiOutRegFromBackValid,
           'travelDestiOutRegToBack'=>$this->travelDestiOutRegToBackValid,
           'travelDateOutRegFromGo'=>$this->travelDateOutRegFromGoValid,
           'travelDateOutRegFromBack'=>$this->travelDateOutRegFromBackValid,
           'ticketDestiOutRegFromGo'=>$this->ticketDestiOutRegFromGoValid,
           'ticketDestiOutRegToGo'=>$this->ticketDestiOutRegToGoValid,
           'ticketDestiOutRegFromBack'=>$this->ticketDestiOutRegFromBackValid,
           'ticketDestiOutRegToBack'=>$this->ticketDestiOutRegToBackValid,
           'ticketDateOutRegFromGo'=>$this->ticketDateOutRegFromGoValid,
           'ticketDateOutRegFromBack'=>$this->ticketDateOutRegFromBackValid,
           'ticketTimeOutRegGo'=>$this->ticketTimeOutRegGoValid,
           'ticketTimeOutRegBack'=>$this->ticketTimeOutRegBackValid,
           'lodgingOutRegDay'=>$this->lodgingOutRegDayValid,
           'transportOutRegDay'=>$this->transportOutRegDayValid,
           'mealOutRegDay'=>$this->mealOutRegDayValid,
           'otherOutRegDay'=>$this->otherOutRegDayValid,
           'lodgingOutRegCost'=>$this->lodgingOutRegCostValid,
           'transportOutRegCost'=>$this->transportOutRegCostValid,
           'mealOutRegCost'=>$this->mealOutRegCostValid,
           'otherOutRegCost'=>$this->otherOutRegCostValid,
       ];
   } 
   public function messages(){
       return [
           'required' => ':attribute wajib diisi!',
           'date_format'=>':attribute menggunakan format d/m/y',
           'numeric'=>':attribute menggunakan format angka',
           'digits_between'=>':attribute menggunakan 1 karakter s/d 2 karakter',
           'not_in'=>':attribute tdl boleh menggunakan angka 0',
           'max'=>':attribute tidak boleh lebih dari :max karakter',
           'min'=>':attribute tidak boleh kurang dari :min karakter',
           'not_regex'=>':attribute karakter tdk valid',
           
           //BAGIAN IN SITE
           'startDateInSite.after'=>':attribute harus lebih dari tgl hari ini',
           'endDateInReg.after_or_equal'=>':attribute harus lebih atau sama dgn tanggal mulai tugas/training',				
           
           //BAGIAN IN REGIONAL
           'startDateInReg.after'=>':attribute harus lebih dari tgl hari ini',
           'endDateInReg.after_or_equal'=>':attribute harus lebih atau sama dgn tanggal mulai tugas/training',			
           'travelDestiInRegToGo.different'=>':attribute tdk boleh sama dgn asal keberangkatan travel dari site',
           'travelDestiInRegFromBack.different'=>':attribute tdk boleh sama dgn asal keberangkatan travel dari site',
           'travelDestiInRegToBack.different'=>':attribute tdk boleh sama dgn tujuan keberangkatan travel dari site atau tdk boleh sama dgn asal keberangkatan travel ke site',
           'travelDateInRegFromGo.after'=>':attribute harus lebih dari tgl hari ini',
           'travelDateInRegFromGo.same'=>':attribute harus sama dgn tgl mulai tugas/training',
           'travelDateInRegFromBack.after_or_equal'=>':attribute harus lebih atau sama dgn tgl mulai tugas/training',
           'travelDateInRegFromBack.same'=>':attribute harus sama sgn tgl akhir tugas/training',
           
           //BAGIAN OUT REGIONAL
           'startDateOutReg.after'=>':attribute harus lebih dari tgl hari ini',
           'endDateOutReg.after'=>':attribute harus lebih dari tgl tiket kembali ke site',
           'ticketDestiOutRegToGo.different'=>':attribute tdk boleh sama dgn asal keberangkatan tiket dari site',
           'ticketDestiOutRegFromBack.different'=>':attribute tdk boleh sama dgn asal keberangkatan tiket dari site',
           'ticketDestiOutRegToBack.different'=>':attribute tdk boleh sama dgn asal keberangkatan tiket kembali ke site atau tdk boleh sama dgn tujuan keberangkatan tiket dari site',
           'ticketDateOutRegFromGo.after'=>':attribute harus lebih dari tgl hari ini',
           'ticketDateOutRegFromGo.same'=>':attribute harus sama dgn tgl'.date("d/m/Y",strtotime(str_replace('/', '-', $this->startDateOutReg).'+'.$this->addDay.'days')),
           'ticketDateOutRegFromBack.after'=>':attribute harus lebih dari tgl keberangkatan tiket dari site',
           'ticketDateOutRegFromBack.same'=>':attribute harus sama dgn tgl'.date("d/m/Y",strtotime(str_replace('/', '-', $this->endDateOutReg).'-'.$this->addDay.'days')),
           'ticketTimeOutRegGo.date_format:"H:i"'=>':attribute menggunakan format hh:mm',
           'ticketTimeOutRegBack.date_format:"H:i"'=>':attribute menggunakan format hh:mm',			
           'travelDestiOutRegToGo.different'=>':attribute tdk boleh sama dgn asal keberangkatan dari site',
           'travelDestiOutRegFromBack.different'=>':attribute tdk boleh sama dgn asal keberangkatan dari site',
           'travelDestiOutRegToBack.different'=>':attribute tdk boleh sama dgn tujuan keberangkatan dari site atau tdk boleh sama dgn asal keberangkatan ke site',
           'travelDateOutRegFromGo.after'=>':attribute harus lebih dari tgl hari ini',
           'travelDateOutRegFromGo.same'=>':attribute harus sama dgn tgl mulai tugas/training',
           'travelDateOutRegFromBack.after'=>':attribute harus lebih dari tgl tiket kembali ke site',
           'travelDateOutRegFromBack.same'=>':attribute harus sama sgn tgl akhir tugas/training',
       ];
   }

}
