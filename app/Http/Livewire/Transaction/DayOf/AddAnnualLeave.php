<?php

namespace App\Http\Livewire\Transaction\DayOf;


use Livewire\Component;
use App\Models\Site;
use App\Models\Poh;
use App\Models\DayOf;
use Carbon\Carbon;
use Auth;
use App\Models\AnnualLeave;
use App\Models\AnnualLeaveCounter;
use App\Models\Permission;
use App\Models\PohAnnualLeave;
use App\Models\PermissionDebt;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Rules;
class AddAnnualLeave extends Component
{
    public $dayOfId;
    public $employeeId ;
    public $site;
    public $poh;
    public $siteName;
    public $pohName;
    public $number;
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

    public $annualLeaveLess;
    public $annualLeaveStandartDay;
    public $annualLeaveStartDate='';
    public $annualLeaveEndDate='';

    public $expireCheck;

    public $addDayThree=3;
    public $addDay=1;

    public $onSiteDate;
    public $onSiteDayCalculate;
    public $annualleaveShouldDay;
    public $annualLeaveStandartMax;

    public $dayOfStandartDayTravel;
    public $dayOfStandartDayTicket;
    public $dayOfStandartSite;
    public $dayOfStandartPoh;  

    public $updateTicketDateFromBack;

    //Permission  Debt
    public $permissionDebtLess;
    //public $permissionNumberReference;

    protected $listeners = [
        'selectAnnualLeaveStartDate'=>'getSelectAnnualLeaveStartDate',
        'selectAnnualLeaveEndDate'=>'getSelectAnnualLeaveEndDate',
        'selectTicketDateFromBack'=>'getSelectTicketDateFromBack',
        'selectTravelDateFromBack'=>'getSelectTravelDateFromBack',
    ];

    protected $validationAttributes = [
        'annualLeaveStartDate' => 'Tanggal mulai',
        'annualLeaveEndDate' => 'Tanggal akhir',
        'ticketDateFromBack'=>'Tanggal tiket kembali',
        'travelDateFromBack'=>'Tanggal travel kembali',
    ];

    public function mount($id){
        $dateNows=Carbon::now();
        $years= $dateNows->year;
        $months= date('m',strtotime($dateNows));   
        $yearMonths=date('Y',strtotime($years)).'/'.$months;
        $countChecks=DayOf::where('site_id',Auth::user()->site->id)->whereMonth('created_at',$months)->whereYear('created_at', $years)->count();
        //$dayOfs=DayOf::where('id',$id)->where('active','1')->where('approv','0')->first();
        $dayOfs=DayOf::find($id);
        if($dayOfs){
            $this->dayOfId=$dayOfs->id;
            $this->employeeId = $dayOfs->user_id;
            $this->site = $dayOfs->site_id;
            $this->poh = $dayOfs->poh_id;
            $this->siteName = $dayOfs->site->name;
            $this->pohName = $dayOfs->poh->name;
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
            
            

            $this->annualLeaveStartDate =   date('d/m/Y', strtotime(str_replace('/', '-', $dayOfs->end). ' + '.$this->addDay.' days')); 
            
            $annualLeaves=AnnualLeave::where('user_id', $this->employeeId)->where('active','1')->where('approv','1')->latest()->first();
           

            $pohAnnualLeaves=PohAnnualLeave::where('site_id', $this->site)->where('poh_id', $this->poh)->where('active','1')->latest()->first();
            if($pohAnnualLeaves){
                $this->annualLeaveStandartDay=$pohAnnualLeaves->day_of;
            }
            $employees=User::find($this->employeeId);

            $annualLeaveCounters=AnnualLeaveCounter::where('user_id', $this->employeeId)->latest()->first();

            if($employees){
                if($annualLeaveCounters!=null){
                    $this->onSiteDate=$annualLeaveCounters->first_date;
                    $this->expireCheck=yearCalculate(date('Y-m-d',strtotime($annualLeaveCounters->first_date)));
                }else{
                    $this->onSiteDate=$employees->join_date;
                    $this->expireCheck=yearCalculate(date('Y-m-d',strtotime($employees->join_date)));
                } 
            }

            if($annualLeaveCounters){
                if($annualLeaveCounters->less>0){
                    //2 = 2 tahun yg merupakan expire cuti tahunan
                    if($this->expireCheck<=2){
                            $this->annualLeaveLess=$annualLeaveCounters->less;
                            $this->annualleaveShouldDay=$this->annualLeaveLess;
                    }else{
                        $this->annualLeaveLess=0;
                        $this->annualleaveShouldDay=$this->annualLeaveStandartDay;
                    }
                }else{
                    $this->annualLeaveLess=0;
                }
            }else{
                $this->annualleaveShouldDay=$this->annualLeaveStandartDay;
            }
            $onSiteDateReps= str_replace('/', '-', $this->onSiteDate);
            $annualLeaveStartDateReps= str_replace('/', '-', $this->annualLeaveStartDate);
            $this->onSiteDayCalculate=CountDay($onSiteDateReps,$annualLeaveStartDateReps);
            
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

            
                $permissionDebts=PermissionDebt::select('permission_debts.less_day','a.number')
                ->leftjoin('permissions as a', 'a.id', '=', 'permission_debts.permission_id')
                ->where('permission_debts.user_id',$dayOfs->user_id)
                ->where('for','AnnualLeave')
                ->where('permission_debts.approv','1')->where('permission_debts.active','1')->first();

                $permissionDebtLesss=PermissionDebt::where('user_id',$dayOfs->user_id)->where('for','AnnualLeave')->where('approv','1')->where('year',date('Y'))->sum('less_day');
                /*if($permissionDebts){
                    if($permissionDebts->less_day>0){
                        $this->permissionDebtLess=$permissionDebts->less_day;
                        $this->permissionNumberReference=$permissionDebts->number;
                    }else{
                        $this->permissionDebtLess=0;
                        $this->permissionNumberReference='';
                    }
                }*/

                if($permissionDebtLesss){
                    if($permissionDebtLesss>0){
                        $this->permissionDebtLess=$permissionDebtLesss;
                    }elseif($permissionDebtLesss==null or $permissionDebtLesss==''){
                        $this->permissionDebtLess=0;

                    }elseif(empty($permissionDebtLesss)){
                        $this->permissionDebtLess=0;
                    }
                    else{
                        $this->permissionDebtLess=0;
                    }
                }
        }

        //$this->annualLeaveStandartMax= date('d/m/Y', strtotime(str_replace('/', '-', $this->annualLeaveStartDate). ' + '.$this->annualLeaveStandartDay.' days - '.$this->addDay.' days'));
    }
    
    /*public function updated($property, $value){
        if(trim($value)){
            $this->validateOnly($property);
        }else{
            $this->resetErrorBag($property);
        }
    }*/

        
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render(){
        $administrators=User::where('level','administrator')->where('active','1')->get();
        if($this->permissionDebtLess>0){
            $this->annualLeaveStandartMax= date('d/m/Y', strtotime(str_replace('/', '-', $this->annualLeaveStartDate). ' + '.$this->annualleaveShouldDay.' days - '.$this->addDay.' days -'.$this->permissionDebtLess.' days'));
        }else{
            $this->annualLeaveStandartMax= date('d/m/Y', strtotime(str_replace('/', '-', $this->annualLeaveStartDate). ' + '.$this->annualleaveShouldDay.' days - '.$this->addDay.' days'));
        }
        $this->planDate =  date('d/m/Y', strtotime(str_replace('/', '-',$this->startDate).'-'.$this->dayOfStandartDayTravel.'days -'.$this->dayOfStandartDayTicket.'days'));
        return view('livewire.transaction.day-of.add-annual-leave',compact('administrators'))->extends('layouts.app')->section('content');
    }

    public function store(){
        $this->validate();
        $planDateRep= str_replace('/', '-', $this->planDate); 
        $startDateRep= str_replace('/', '-', $this->startDate);
        $annualLeaveStartDateRep= str_replace('/', '-', $this->annualLeaveStartDate);
        $annualLeaveEndDateRep= str_replace('/', '-', $this->annualLeaveEndDate);   
        $ticketDateFromBackRep= str_replace('/', '-', $this->ticketDateFromBack);		
        $travelDateFromBackRep= str_replace('/', '-', $this->travelDateFromBack);
        $annualLeaveCalculate=CountDay($annualLeaveStartDateRep,$annualLeaveEndDateRep);  
        $inDateRep= str_replace('/', '-', $this->inDate);

        $dayOfTotalCalculate=  CountDay($startDateRep,$annualLeaveEndDateRep);
        $dayOfGrandTotalCalculate=  CountDay($planDateRep,$travelDateFromBackRep);

        DB::beginTransaction();
        try{
            $dayofs = DayOf::where('id',$this->dayOfId)->first();
            $dayofs->in = date('Y-m-d', strtotime($inDateRep));
            $dayofs->day_of_total=$dayOfTotalCalculate + $this->addDay;
            $dayofs->day_of_grandtotal=$dayOfGrandTotalCalculate + $this->addDay;
            $dayofs->travel_from_back=date('Y-m-d', strtotime($travelDateFromBackRep));		
            $dayofs->ticket_from_back=date('Y-m-d', strtotime($ticketDateFromBackRep));
            $dayofs->save();

            $annualLeaves = new AnnualLeave();
            $annualLeaves->user_id = $this->employeeId;
            $annualLeaves->site_id = $this->site;
            $annualLeaves->poh_id = $this->poh;
            $annualLeaves->day_of_id = $this->dayOfId;
            $annualLeaves->year = date('Y', strtotime($annualLeaveStartDateRep));
            $annualLeaves->start = date('Y-m-d', strtotime($annualLeaveStartDateRep));
            $annualLeaves->end = date('Y-m-d', strtotime($annualLeaveEndDateRep));
            $annualLeaves->sum=$annualLeaveCalculate + $this->addDay;
            $annualLeaves->standart=$this->annualLeaveStandartDay;
            $annualLeaves->should=$this->annualLeaveStandartDay + $this->annualLeaveLess;
            $annualLeaves->less=($this->annualLeaveStandartDay +  $this->annualLeaveLess)-($annualLeaveCalculate + $this->addDay);
            $annualLeaves->less_before=null;
            $annualLeaves->approv='0';
            $annualLeaves->active = '1';
            $annualLeaves->save();

            if($this->annualLeaveLess==0){
                $annualLeaveCounters = new AnnualLeaveCounter();
                $annualLeaveCounters->user_id =$this->employeeId;
                $annualLeaveCounters->site_id =$this->site;
                $annualLeaveCounters->year = date('Y', strtotime($annualLeaveStartDateRep));
                $annualLeaveCounters->day=$annualLeaveCalculate + $this->addDay;
                $annualLeaveCounters->standart=$this->annualLeaveStandartDay;
                $annualLeaveCounters->should=$this->annualLeaveStandartDay + $this->annualLeaveLess;
                $annualLeaveCounters->less=($this->annualLeaveStandartDay +  $this->annualLeaveLess)-($annualLeaveCalculate + $this->addDay);
                $annualLeaveCounters->less_before=null;
                $annualLeaveCounters->first_date = date('Y-m-d', strtotime($annualLeaveStartDateRep));
                $annualLeaveCounters->last_date = date('Y-m-d', strtotime($annualLeaveEndDateRep));
                $annualLeaveCounters->save();
            }else{
                $annualLeaveCounters = AnnualLeaveCounter::where('user_id',$this->employeeId)->where('less','>',0)->latest()->first();
                $annualLeaveCounters->day=$annualLeaveCalculate + $this->addDay;
                $annualLeaveCounters->standart=$this->annualLeaveStandartDay;
                $annualLeaveCounters->should=$this->annualLeaveStandartDay + $this->annualLeaveLess;
                $annualLeaveCounters->less=($this->annualLeaveStandartDay +  $this->annualLeaveLess)-($annualLeaveCalculate + $this->addDay);
                $annualLeaveCounters->less_before=null;
                $annualLeaveCounters->last_date = date('Y-m-d', strtotime($annualLeaveEndDateRep));
                $annualLeaveCounters->save();
            }


            $this->emit('refreshDropdown');
            session()->flash('message', 'Berhasil menyimpan data!');
            $this->initializedProperties();
            redirect()->route('my-day-of');


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
        $this->dayOfId=null;
        $this->employeeId =null;
        $this->site=null;
        $this->poh=null;
        $this->number=null;
        $this->planDate=null;
        $this->startDate=null;
        $this->endDate=null;
        $this->inDate=null;
        $this->inDateBefore=null;
        $this->workDay=null;
        $this->dayOfSum=null;
        $this->dayOfTotal=null;
        $this->dayOfGrandTotal=null;
        $this->dayOfStandart=null;
        $this->dayOfShould=null;
        $this->dayOfLess=null;
        $this->travelDateFromGo=null;
        $this->travelDateFromBack=null;
        $this->ticketDateFromGo=null;	
        $this->ticketDateFromBack=null;
        $this->ticketTimeGo=null;
        $this->ticketTimeBack=null;
        $this->travelDayGo=null;
        $this->travelDayBack=null;
        
        $this->annualLeaveLess=null;
        $this->annualLeaveStandartDay=null;
        $this->annualLeaveStartDate=null;
        $this->annualLeaveEndDate=null;
        
        $this->expireCheck=null;
        $this->onSiteDate=null;
        $this->onSiteDayCalculate=null;
        $this->annualleaveShouldDay=null;
        $this->annualLeaveStandartMax=null;
        $this->updateTicketDateFromBack=null;

        $this->dayOfStandartDayTravel=null;
        $this->dayOfStandartDayTicket=null;
        $this->dayOfStandartSite=null;
        $this->dayOfStandartPoh=null;  

        $this->permissionDebtLess=null;
        //$this->permissionNumberReference=null;
    }
    public function getSelectAnnualLeaveStartDate( $value) {
        $this->annualLeaveStartDate=$value;
    }

    public function getSelectAnnualLeaveEndDate( $value) {
        $this->annualLeaveEndDate=$value;  
        if($this->annualLeaveEndDate!='' or $this->annualLeaveEndDate!=null){
            $this->ticketDateFromBack =  date('d/m/Y', strtotime(str_replace('/', '-',$this->annualLeaveEndDate).'+'.$this->addDay.'days'));
            $this->travelDateFromBack =  date('d/m/Y', strtotime(str_replace('/', '-',$this->annualLeaveEndDate).'+'.$this->addDay.'days'));
            $this->inDate =  date('d/m/Y', strtotime(str_replace('/', '-',$this->travelDateFromBack).'+'.$this->dayOfStandartDayTravel.'days +'.$this->dayOfStandartDayTicket.'days'));
        }else{
            $this->ticketDateFromBack=$this->ticketDateFromBack;
            $this->travelDateFromBack=$this->travelDateFromBack;
            $this->inDate= $this->inDate;
        }
    }

    public function getSelectTicketDateFromBack( $value) {
        $this->ticketDateFromBack=$value;
    }

    public function getSelectTravelDateFromBack( $value) {
        $this->travelDateFromBack=$value;
    }

    /*public function getSelectTravelDestiFromBack( $value) {
        $this->travelDestiFromBack=$value;
    }*/

    public function rules (){

        if($this->ticketDateFromBack!=='' or $this->ticketDateFromBack!==null){
            $this->ticketDateFromBackValidate='required|date_format:"d/m/Y"|after:annualLeaveEndDate';
        }else{
            $this->ticketDateFromBackValidate='nullable';
        }
        if($this->travelDateFromBack!=='' or $this->travelDateFromBack!==null){
            $this->travelDateFromBackValidate='required|date_format:"d/m/Y"|after:annualLeaveEndDate|before_or_equal:'.date("Y-m-d",strtotime(str_replace('/', '-', $this->inDate).'-'.$this->addDay.'days')); 
        }else{
            $this->travelDateFromBackValidate='nullable'; 
        }
        if($this->dayOfStandartDayTravel>0){
            $this->ticketDateFromBackValidate='required|date_format:"d/m/Y"|after:annualLeaveEndDate';
            $this->travelDateFromBackValidate='required|date_format:"d/m/Y"|after:annualLeaveEndDate|before_or_equal:'.date("Y-m-d",strtotime(str_replace('/', '-', $this->inDate).'-'.$this->addDay.'days')); 
        }else{
            $this->ticketDateFromBackValidate='nullable';
            $this->travelDateFromBackValidate='nullable';            
        }
        return[  
            'annualLeaveStartDate'=>'required|date_format:"d/m/Y"|after:endDate',	
            'annualLeaveEndDate'=>'required|date_format:"d/m/Y"|after_or_equal:annualLeaveStartDate|before_or_equal:'.$this->annualLeaveStandartMax,
            'ticketDateFromBack'=>$this->ticketDateFromBackValidate,
            'travelDateFromBack'=>$this->travelDateFromBackValidate,
        ];
    }
    public function messages(){
        return  [
            'required' => ':attribute wajib diisi!',
            'annualLeaveEndDate.date_format'=>':attribute harus menggunakan format dd/mm/yyyy',
            'annualLeaveEndDate.after_or_equal'=>':attribute harus sama atau lebih dari tgl mulai cuti tahunan',
            'annualLeaveEndDate.before_or_equal'=>':attribute tdk boleh lebih dari tgl '.$this->annualLeaveStandartMax,
            'ticketDateFromBack.after'=>':attribute harus lebih dari tgl selesai cuti jobsite',
            

            'travelDateFromBack.date_format'=>':attribute harus menggunakan format dd/mm/yyyy',
            'travelDateFromBack.after'=>':attribute harus lebih dari tgl selesai cuti jobsite',
            'travelDateFromBack.before_or_equal'=>':attribute tdk boleh lebih dari tgl '.date("d/m/Y",strtotime(str_replace('/', '-', $this->onSiteDate).'-'.$this->addDay.'days')),
        ];
    }
 

}