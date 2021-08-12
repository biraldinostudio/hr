<?php

namespace App\Http\Livewire\Transaction\DayOf;

use App\Models\DayOf;
use App\Models\DayOfDestination;
use Livewire\Component;
use App\Models\Destination;
use App\Models\User;
use App\Models\DayOfPeriod;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
class Create extends Component
{
    public $site;
    public $poh;
   
    public $planDate='';
    //rute tiket:
    public $ticketDestiFromGo='';
    public $ticketDestiToGo='';
    public $ticketDestiFromBack='';
    public $ticketDestiToBack='';
    public $ticketDateFromGo='';
    public $ticketDateFromBack='';
    public $ticketTimeGo='';
    public $ticketTimeBack='';

    //Cuti jobsite / reguler:
    public $startDate='';
    public $endDate='';

    //Rute travel:
    public $travelDestiFromGo='';
    public $travelDestiToGo='';
    public $travelDateFromGo='';
    public $travelDestiFromBack='';
    public $travelDestiToBack='';
    public $travelDateFromBack='';

    public $description='';
    public $onSiteDate='';

    public $addDay=1;
    public $addDayThree=3;

    //Standart
    public $dayOfStandartDay;
    public $dayOfStandartDayTravel;
    public $dayOfStandartDayTicket;
    public $dayOfStandartSite;
    public $dayOfStandartPoh; 
    public $dayOfStandartMax;

    //Checking
    public $dayOfPeriod;
    public $workDayFirst;
    public $latestDayOf;
    public $latestDayOfStandart;
    public $latestDayOfShould;
    public $latestDayOfLess;

    public $latestDayOfIn;
    public $workDay;

    //lumpsum
    public $lumpsum;
    public $lumpsum_status;

    //vallidate
    public $ticketDestiFromGoValidate;
    public $ticketDestiToGoValidate;
    public $ticketDestiFromBackValidate;
    public $ticketDestiToBackValidate;
    public $ticketDateFromGoValidate;
    public $ticketDateFromBackValidate;
    public $ticketTimeGoValidate;
    public $ticketTimeBackValidate;
    public $travelDestiFromGoValidate;
    public $travelDestiToGoValidate;
    public $travelDateFromGoValidate;
    public $travelDestiFromBackValidate;
    public $travelDestiToBackValidate;
    public $travelDateFromBackValidate; 

    public $rangeTravelDateFromBack;
    //nomor dokumen;
    public $number;

    //Cek Day Of Open;
    public $latestDayOfOpen;
    public $latestDayOfOpenNumber;

    public $homeFacility;
    protected $listeners = [
       'selectPlanDate' => 'getSelectedPlanDate',
        'selectTicketDestiFromGo'=>'getSelectTicketDestiFromGo',
        'selectTicketDestiToGo'=>'getSelectTicketDestiToGo',
        'selectTicketDateFromGo'=>'getSelectTicketDateFromGo',
        'selectTicketTimeGo'=>'getSelectTicketTimeGo',
        'selectTicketDestiFromBack'=>'getSelectTicketDestiFromBack',
        'selectTicketDestiToBack'=>'getSelectTicketDestiToBack',
        'selectTicketDateFromBack'=>'getSelectTicketDateFromBack',
        'selectTicketTimeBack'=>'getSelectTicketTimeBack',
        'selectStartDate'=>'getSelectStartDate',
        'selectEndDate'=>'getSelectEndDate',
        'selectTravelDestiFromGo'=>'getSelectTravelDestiFromGo',
        'selectTravelDestiToGo'=>'getSelectTravelDestiToGo',
        'selectTravelDateFromGo'=>'getSelectTravelDateFromGo',
        'selectTravelDestiFromBack'=>'getSelectTravelDestiFromBack',
        'selectTravelDestiToBack'=>'getSelectTravelDestiToBack',
        'selectTravelDateFromBack'=>'getSelectTravelDateFromBack',
        'selectOnSiteDate'=>'getSelectOnSiteDate',
    ];

    protected $validationAttributes = [
        'planDate'=>'Tgl rencana',
        'ticketDestiFromGo'=>'Tiket asal keberangkatan cuti',
        'ticketDestiToGo'=>'Tiket tujuan keberangkatan cuti',
        'ticketDestiFromBack'=>'Tiket asal keberangkatan kembali ke site',
        'ticketDestiToBack'=>'Tiket tujuan kembali ke site',
        'ticketDateFromGo'=>'Tgl tiket keberangkatan cuti',
        'ticketDateFromBack'=>'Tgl tiket kembali ke site',
        'ticketTimeGo'=>'Jam tiket keberangkatan cuti',
        'ticketTimeBack'=>'Jam tiket keberangkatan kembali ke site',
        'startDate'=>'Tgl mulai cuti jobsite',
        'endDate'=>'Tgl akhir cuti jobsite',
        'travelDestiFromGo'=>'Travel keberangkatan cuti',
        'travelDestiToGo'=>'Travel tujuan cuti',
        'travelDateFromGo'=>'Tgl travel keberangkatan cuti',
        'travelDestiFromBack'=>'Travel keberangkatan kembali ke site',
        'travelDestiToBack'=>'Travel tujuan kembali ke site',
        'travelDateFromBack'=>'Tgl travel kembali ke site',
        'description'=>'Keterangan tambahan',
    ];

    public function mount(){
        $dayOfStandarts = User::select('c.day_of as day','c.travel_day as dayTravel','c.travel_day_ticket as dayTicket','a.name as site','b.name as poh')
        ->join('sites as a', 'a.id', '=', 'users.site_id')
        ->join('pohs as b', 'b.id', '=', 'users.poh_id')
        ->leftjoin('poh_day_ofs as c', function ($join) {
            $join->on('c.site_id', '=', 'a.id')
                 ->on('c.poh_id', '=', 'b.id');
            })
        ->where('users.id',Auth::user()->id)->first();

        $this->dayOfStandartDay=$dayOfStandarts->day;
        //$this->dayOfStandartDayTravel=$dayOfStandarts->dayTravel/2;
        //$this->dayOfStandartDayTicket=$dayOfStandarts->dayTicket/2;
        $this->dayOfStandartSite=$dayOfStandarts->site;
        $this->dayOfStandartPoh=$dayOfStandarts->poh;
        if($dayOfStandarts->dayTravel==1){
            $this->dayOfStandartDayTravel=1;
        }else{
            $this->dayOfStandartDayTravel=$dayOfStandarts->dayTravel/2;
        }

        if($dayOfStandarts->dayTicket==1){
            $this->dayOfStandartDayTicket=1;
        }else{
            $this->dayOfStandartDayTicket=$dayOfStandarts->dayTicket/2;
        }

        $dayOfPeriods=DayOfPeriod::select('staff','day')->where('staff',Auth::user()->staff)->first();
        if($dayOfPeriods){
            $this->dayOfPeriod=$dayOfPeriods->day;
            
            $joinDates=User::select('join_date')->where('id',Auth::user()->id)->first(); 
            $planDateReps= str_replace('/', '-', date('Y-m-d'));
            $this->workDayFirst=CountDay($planDateReps,$joinDates->join_date);
        }
        $latestDayOfs=DayOf::where('user_id',Auth::user()->id)->where('approv','1')->where('active','1')->latest()->first();
        $latestDayOfOpens=DayOf::where('user_id',Auth::user()->id)->where('approv','0')->where('active','1')->latest()->first();
        if($latestDayOfOpens){
            if(!empty($latestDayOfOpens)){
                $this->latestDayOfOpen=$latestDayOfOpens->count();
                $this->latestDayOfOpenNumber=$latestDayOfOpens->number;
            }
        }
        if($latestDayOfs){
            if($latestDayOfs!='' or $latestDayOfs!=null){
                $this->latestDayOf=$latestDayOfs->start;
                $this->latestDayOfStandart=$latestDayOfs->day_of_standart;
                $this->latestDayOfShould=$latestDayOfs->day_of_should;
                $this->latestDayOfLess=$latestDayOfs->day_of_less;
                $this->latestDayOfIn=$latestDayOfs->in;

                $latestStartReps= str_replace('/', '-',$latestDayOfs->in);
                $onSiteDayNows=CountDay($planDateReps,$latestStartReps);
                
                $this->workDay=$onSiteDayNows;
            }else{
                $this->workDay= $this->workDayFirst;
                $this->latestDayOfLess=0;
                $this->latestDayOfIn=date('Y-m-d',strtotime(Auth::user()->join_date));
            }       
        }

        $this->site=Auth::user()->site->id;
        $this->poh=Auth::user()->poh->id;
        

        $userLumpsums = User::select('home_facilities','lumpsum','lumpsum_status')         
            ->where('id',Auth::user()->id)->first();

        $this->homeFacility=$userLumpsums->home_facilities;
        if($userLumpsums->home_facilities!='1'){
            $this->lumpsum=$userLumpsums->lumpsum;
            $this->lumpsum_status=$userLumpsums->lumpsum_status;
        }else{
            $this->lumpsum=0;
            $this->lumpsum_status=0; 
        }
        

        //Bagian nomor dokumen
        $dateNows=Carbon::now();
        $years= $dateNows->year;
        $months= date('m',strtotime($dateNows));   
        $yearMonths=date('Y',strtotime($years)).'/'.$months;
        $countChecks=DayOf::where('site_id',Auth::user()->site->id)->whereMonth('created_at',$months)->whereYear('created_at', $years)->count();
        if($countChecks==0){
            $orders='1001';
            $this->number='RML-'.Auth::user()->site->code.'/'.'ST/'.$yearMonths.'/'.$orders;
        }else{
            $getOrders=DayOf::where('site_id',Auth::user()->site->id)->whereMonth('created_at',$months)->whereYear('created_at', $years)->latest()->first();
            $orders=(int)substr( $getOrders->number,-4) + 1;
            $this->number='RML-'.Auth::user()->site->code.'/'.'ST/'.$yearMonths.'/'.$orders;
        }

        $this->initializedProperties();
    }
    
    public function updated($property, $value){
        
        if(trim($value)){
            $this->validateOnly($property);
        }else{
            $this->resetErrorBag($property);
        }
    }

    /*public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }*/

    public function render(){
        $this->dayOfStandartMax= date('d/m/Y', strtotime(str_replace('/', '-', $this->startDate). ' + '.$this->dayOfStandartDay.' days - '.$this->addDay.' days'));
        $administrators=User::where('level','administrator')->where('active','1')->get();
        $destinations=Destination::select('id','name')->where('active','1')->get();
        return view('livewire.transaction.day-of.create',compact('destinations','administrators'))->extends('layouts.app')->section('content');
    }

    public function store(){
        $this->validate();
        $planDateRep= str_replace('/', '-', $this->planDate);  
        $startDateRep= str_replace('/', '-', $this->startDate);
        $endDateRep= str_replace('/', '-', $this->endDate); 
        
        $ticketDateFromGoRep= str_replace('/', '-', $this->ticketDateFromGo);
        $ticketDateFromBackRep= str_replace('/', '-', $this->ticketDateFromBack);		
        
        $travelDateFromGoRep= str_replace('/', '-', $this->travelDateFromGo);
        $travelDateFromBackRep= str_replace('/', '-', $this->travelDateFromBack);

        $dayOfCalculate=CountDay($startDateRep,$endDateRep);

        $onSiteDateRep= str_replace('/', '-', $this->onSiteDate);

        $dayOfTotalCalculate=  CountDay($startDateRep,$endDateRep);
        $dayOfGrandTotalCalculate=  CountDay($planDateRep,$endDateRep);

        $travelDayGo=CountDay($travelDateFromGoRep,$ticketDateFromGoRep) + $this->addDay;
        $travelDayBack=CountDay($ticketDateFromBackRep,$travelDateFromBackRep) + $this->addDay;	 

        if($this->dayOfStandartDayTravel>0){
            $travelDateFromGoRecords=date('Y-m-d', strtotime($travelDateFromGoRep));
            $travelDateFromBackRecords=date('Y-m-d', strtotime($travelDateFromBackRep));
            $ticketDateFromGoRecords=date('Y-m-d', strtotime($ticketDateFromGoRep));
            $ticketDateFromBackRecords=date('Y-m-d', strtotime($ticketDateFromBackRep));
            $travelDayGoRecords=$travelDayGo;
            $travelDayBackRecords=$travelDayBack;
            $ticketTimeGoRecords=$this->ticketTimeGo;
            $ticketTimeBackRecords=$this->ticketTimeBack;
        }else{
            $travelDateFromGoRecords=null;
            $travelDateFromBackRecords=null;
            $ticketDateFromGoRecords=null;
            $ticketDateFromBackRecords=null;
            $travelDayGoRecords=0;
            $travelDayBackRecords=0;
            $ticketTimeGoRecords=null;
            $ticketTimeBackRecords=null; 
        }

       DB::beginTransaction();
        try{
            
		    $dayofs = new DayOf();
            $dayofs->user_id = Auth::user()->id;
            $dayofs->site_id = $this->site;
            $dayofs->poh_id = $this->poh;
            $dayofs->number=$this->number;
            $dayofs->start = date('Y-m-d', strtotime($startDateRep));
            $dayofs->end = date('Y-m-d', strtotime($endDateRep));
            $dayofs->in = date('Y-m-d', strtotime($onSiteDateRep));
            $dayofs->in_before = date('Y-m-d', strtotime($this->latestDayOfIn));
            $dayofs->work_day=$this->workDay;
            $dayofs->day_of_sum=$dayOfCalculate + $this->addDay;
            $dayofs->day_of_total=$dayOfTotalCalculate + $this->addDay;
            $dayofs->day_of_grandtotal=$dayOfGrandTotalCalculate + $this->addDay;
            $dayofs->day_of_standart=$this->dayOfStandartDay;
            $dayofs->day_of_should=$this->dayOfStandartDay+$this->latestDayOfLess;
            $dayofs->day_of_less=($this->dayOfStandartDay+$this->latestDayOfLess)-($dayOfCalculate + $this->addDay);
            $dayofs->travel_from_go=$travelDateFromGoRecords;
            $dayofs->travel_from_back=$travelDateFromBackRecords;
            $dayofs->ticket_from_go=$ticketDateFromGoRecords;		
            $dayofs->ticket_from_back=$ticketDateFromBackRecords;
            $dayofs->ticket_time_go=$ticketTimeGoRecords;
            $dayofs->ticket_time_back=$ticketTimeBackRecords;
            $dayofs->travel_day_go=$travelDayGoRecords;
            $dayofs->travel_day_back=$travelDayBackRecords;			
            $dayofs->description=$this->description;
            $dayofs->lumpsum=currencyIDRToNumeric($this->lumpsum);
            $dayofs->update_count = null;
            $dayofs->active = '1';
            $dayofs->save();

            if($this->dayOfStandartDayTravel>0){
                $data = [
                    ['day_of_id'=>$dayofs->id,'from_id'=>$this->ticketDestiFromGo, 'to_id'=>$this->ticketDestiToGo,'type'=> 'Go','destination'=>'Ticket','active'=>'1','created_at'=>date('Y-m-d H:i:s')],
                    ['day_of_id'=>$dayofs->id,'from_id'=>$this->ticketDestiFromBack,'to_id'=>$this->ticketDestiToBack, 'type'=> 'Back','destination'=>'Ticket','active'=>'1','created_at'=>date('Y-m-d H:i:s')],
                    ['day_of_id'=>$dayofs->id,'from_id'=>$this->travelDestiFromGo, 'to_id'=>$this->travelDestiToGo,'type'=> 'Go','destination'=>'Travel','active'=>'1','created_at'=>date('Y-m-d H:i:s')],
                    ['day_of_id'=>$dayofs->id,'from_id'=>$this->travelDestiFromBack,'to_id'=>$this->travelDestiToBack, 'type'=> 'Back','destination'=>'Travel','active'=>'1','created_at'=>date('Y-m-d H:i:s')],
                ];
                DayOfDestination::insert($data);
            }   
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','createModal');
            $this->emit('reloadDayOfs');
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
    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
    private function initializedProperties(){

        $this->planDate=null;
        //rute tiket:
        $this->ticketDestiFromGo=null;
        $this->ticketDestiToGo=null;
        $this->ticketDestiFromBack=null;
        $this->ticketDestiToBack=null;
        $this->ticketDateFromGo=null;
        $this->ticketDateFromBack=null;
        $this->ticketTimeGo=null;
        $this->ticketTimeBack=null;
        
        //Cuti jobsite / reguler:
        $this->startDate=null;
        $this->endDate=null;
        
        //Rute travel berangkat:
        $this->travelDestiFromGo=null;
        $this->travelDestiToGo=null;
        $this->travelDateFromGo=null;
        $this->travelDestiFromBack=null;
        $this->travelDestiToBack=null;
        $this->travelDateFromBack=null;
        
        $this->description=null;
        $this->onSiteDate=null;

        $this->homeFacility;
        
    }

    public function getSelectedPlanDate( $value) {
        $this->planDate=$value;
        if($this->planDate!='' or $this->planDate!=null){
            $this->startDate =  date('d/m/Y', strtotime(str_replace('/', '-',$this->planDate).'+'.$this->dayOfStandartDayTravel.'days +'.$this->dayOfStandartDayTicket.'days')); 
            $this->endDate =   date('d/m/Y', strtotime(str_replace('/', '-', $this->startDate). ' + '.$this->dayOfStandartDay.' days - '.$this->addDay.' days'));
            $this->travelDateFromBack =  date('d/m/Y', strtotime(str_replace('/', '-',$this->endDate).'+'.$this->addDay.'days'));
            $this->onSiteDate =  date('d/m/Y', strtotime(str_replace('/', '-',$this->travelDateFromBack).'+'.$this->dayOfStandartDayTravel.'days +'.$this->dayOfStandartDayTicket.'days'));
        }else{
            $this->startDate=$this->planDate;
            $this->endDate=$this->planDate;
            $this->travelDateFromBack=$this->planDate;
            $this->onSiteDate =$this->planDate;
        }   
    }
    public function getSelectTicketDestiFromGo( $value) {
        $this->ticketDestiFromGo=$value;
    }
    public function getSelectTicketDestiToGo( $value) {
        $this->ticketDestiToGo=$value;
    }
    public function getSelectTicketDateFromGo( $value) {
        $this->ticketDateFromGo=$value;
    }
    public function getSelectTicketTimeGo( $value) {
        $this->ticketTimeGo=$value;
    }
    public function getSelectTicketDestiFromBack( $value) {
        $this->ticketDestiFromBack=$value;
    }
    public function getSelectTicketDestiToBack( $value) {
        $this->ticketDestiToBack=$value;
    }
    public function getSelectTicketDateFromBack( $value) {
        $this->ticketDateFromBack=$value;
    }
    public function getSelectTicketTimeBack( $value) {
        $this->ticketTimeBack=$value;
    }
    public function getSelectStartDate( $value) {
        $this->startDate=$value;
    }
    public function getSelectEndDate( $value) {
        $this->endDate=$value;
        if($this->endDate!='' or $this->endDate!=null){
            $this->travelDateFromBack =   date('d/m/Y', strtotime(str_replace('/', '-', $this->endDate). ' + '.$this->addDay.' days')); 
            $this->onSiteDate =  date('d/m/Y', strtotime(str_replace('/', '-',$this->travelDateFromBack).'+'.$this->dayOfStandartDayTravel.'days +'.$this->dayOfStandartDayTicket.'days'));
        }else{
            $this->planDate=$this->endDate;
            $this->startDate=$this->endDate;
            $this->travelDateFromBack=$this->endDate;
            $this->onSiteDate=$this->endDate;
        }
    }

    public function getSelectTravelDestiFromGo( $value) {
        $this->travelDestiFromGo=$value;
    }
    public function getSelectTravelDestiToGo( $value) {
        $this->travelDestiToGo=$value;
    }
    public function getSelectTravelDateFromGo( $value) {
        $this->travelDateFromGo=$value;
    }
    public function getSelectTravelDestiFromBack( $value) {
        $this->travelDestiFromBack=$value;
    }
    public function getSelectTravelDestiToBack( $value) {
        $this->travelDestiToBack=$value;
    }
    public function getSelectTravelDateFromBack( $value) {
        $this->travelDateFromBack=$value;
    }

    public function getSelectOnSiteDate( $value) {
        $this->onSiteDate=$value;
    }
    public function rules (){
        if($this->dayOfStandartDayTravel>0){
            $this->ticketDestiFromGoValidate='required';
            $this->ticketDestiToGoValidate='required|different:ticketDestiFromGo';
            $this->ticketDestiFromBackValidate='required|different:ticketDestiFromGo';
            $this->ticketDestiToBackValidate='required|different:ticketDestiFromBack';
            $this->ticketDateFromGoValidate='required|date_format:"d/m/Y"|after_or_equal:planDate|before_or_equal:'.date("d/m/Y",strtotime(str_replace('/', '-', $this->onSiteDate).'-'.$this->addDay.'days'));
            $this->ticketDateFromBackValidate='required|date_format:"d/m/Y"|after:endDate|before_or_equal:'.date("d/m/Y",strtotime(str_replace('/', '-', $this->onSiteDate).'-'.$this->addDay.'days')); 

            $this->ticketTimeGoValidate='required|date_format:"H:i"';
            $this->ticketTimeBackValidate='required|date_format:"H:i"';
            $this->travelDestiFromGoValidate='required';
            $this->travelDestiToGoValidate='required|different:travelDestiFromGo';
            $this->travelDateFromGoValidate='required|date_format:"d/m/Y"|after_or_equal:planDate|before_or_equal:'.date("d/m/Y",strtotime(str_replace('/', '-', $this->onSiteDate).'-'.$this->addDay.'days'));
            $this->travelDestiFromBackValidate='required|different:travelDestiFromGo';
            $this->travelDestiToBackValidate='required|different:travelDestiFromBack';
            $this->travelDateFromBackValidate='required|date_format:"d/m/Y"|after:endDate|before_or_equal:'.date("Y-m-d",strtotime(str_replace('/', '-', $this->onSiteDate).'-'.$this->addDay.'days')); 
        }else{
            $this->ticketDestiFromGoValidate='nullable';
            $this->ticketDestiToGoValidate='nullable';
            $this->ticketDestiFromBackValidate='nullable';
            $this->ticketDestiToBackValidate='nullable';
            $this->ticketDateFromGoValidate='nullable';
            $this->ticketDateFromBackValidate='nullable';
            $this->ticketTimeGoValidate='nullable';
            $this->ticketTimeBackValidate='nullable';
            $this->travelDestiFromGoValidate='nullable';
            $this->travelDestiToGoValidate='nullable';
            $this->travelDateFromGoValidate='nullable';
            $this->travelDestiFromBackValidate='nullable';
            $this->travelDestiToBackValidate='nullable';
            $this->travelDateFromBackValidate='nullable';            
        }
        return[      
            'planDate' => 'required|date_format:"d/m/Y"|after:'.date("d/m/Y"),
            'ticketDestiFromGo'=>$this->ticketDestiFromGoValidate,
            'ticketDestiToGo'=>$this->ticketDestiToGoValidate,
            'ticketDestiFromBack'=>$this->ticketDestiFromBackValidate,
            'ticketDestiToBack'=>$this->ticketDestiToBackValidate,
            'ticketDateFromGo'=>$this->ticketDateFromGoValidate,
            'ticketDateFromBack'=>$this->ticketDateFromBackValidate,
            'ticketTimeGo'=>$this->ticketTimeGoValidate,
            'ticketTimeBack'=>$this->ticketTimeBackValidate,
            'startDate'=>'required',
            //'endDate'=>'required|date_format:"d/m/Y"|after_or_equal:startDate|before_or_equal:'.$this->dayOfStandartMax,
            'endDate'=>'required|date_format:"d/m/Y"|after_or_equal:startDate',           
            'travelDestiFromGo'=>$this->travelDestiFromGoValidate,
            'travelDestiToGo'=>$this->travelDestiToGoValidate,
            'travelDateFromGo'=>$this->travelDateFromGoValidate,
            'travelDestiFromBack'=>$this->travelDestiFromBackValidate,
            'travelDestiToBack'=>$this->travelDestiToBackValidate,
            'travelDateFromBack'=>$this->travelDateFromBackValidate,
            'description'=>'max:500|nullable',
        ];
    } 
    public function messages(){
        return [
            'required' => ':attribute wajib diisi!',
            'planDate.after'=>':attribute harus lebih dari tgl hari ini',
            'ticketDestiToGo.different'=>':attribute tidak boleh sama dengan nama kota asal keberangkatan cuti',
            'ticketDestiFromBack.different'=>':attribute tidak boleh sama dengan nama kota/lokasi asal keberangkatan cuti',
            'ticketDestiToBack.different'=>':attribute tidak boleh sama dengan nama kota/lokasi asal keberangkatan kembali ke site',
            'ticketDateFromGo.after_or_equal'=>':attribute harus lebih atau sama dengan tgl rencana cuti',
            'ticketDateFromGo.before_or_equal'=>':attribute tdk boleh lebih dari tgl '.date("d/m/Y",strtotime(str_replace('/', '-', $this->onSiteDate).'-'.$this->addDay.'days')),
            'ticketDateFromBack.after'=>':attribute harus lebih dari tgl selesai cuti jobsite', // ini harus cek cuti tahunan
            'ticketDateFromBack.before_or_equal'=>':attribute tdk boleh lebih dari tgl '.date("d/m/Y",strtotime(str_replace('/', '-', $this->onSiteDate).'-'.$this->addDay.'days')),
            'endDate.date_format'=>':attribute harus menggunakan format dd/mm/yyyy',
            'endDate.after_or_equal'=>':attribute harus lebih atau sama dgn tgl mulai cuti jobsite',
            //'endDate.before_or_equal'=>':attribute harus sama atau tdk boleh lebih dari tgl '.$this->dayOfStandartMax,//Ini cek tanggal 14 hari
            'travelDestiToGo'=>':attribute tdk boleh sama dgn nama kota/lokasi travel keberangkatan cuti',
            'different.different'=>':attribute tidak boleh sama dgn nama kota/asal travel keberangkatan cuti',
            'travelDateFromGo.date_format'=>':attribute harus menggunakan format dd/mm/yyyy',
            'travelDateFromGo.after_or_equal'=>':attribute harus sama atau lebih dari tanggal rencana cuti',
            'travelDestiFromBack.different'=>':attribute tdk boleh sama dgn nama kota/lokasi travel keberangkatan cuti',
            'travelDestiToBack.different'=>':attribute tdk boleh sama dgn nama kota/lokasi travel asal keberangkatan kembali ke site',
            'travelDateFromBack.date_format'=>':attribute harus menggunakan format dd/mm/yyyy',
            'travelDateFromBack.after'=>':attribute harus lebih dari tgl selesai cuti jobsite', // cek dengan cuti tahunan
            'travelDateFromGo.before_or_equal'=>':attribute tdk boleh lebih dari tgl '.date("d/m/Y",strtotime(str_replace('/', '-', $this->onSiteDate).'-'.$this->addDay.'days')),
            'max'=>':attribute. tidak boleh lebih dari :max karakter',
            'ticketTimeGo.date_format'=>':attribute harus berformat hh:mm',
            'ticketTimeBack.date_format'=>':attribute harus berformat hh:mm',
            'travelDateFromBack.before_or_equal'=>':attribute tdk boleh lebih dari tgl '.date("d/m/Y",strtotime(str_replace('/', '-', $this->onSiteDate).'-'.$this->addDay.'days')),
        ];
    }

}