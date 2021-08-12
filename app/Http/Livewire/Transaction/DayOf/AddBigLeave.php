<?php

namespace App\Http\Livewire\Transaction\DayOf;

use App\Models\AnnualLeave;
use Livewire\Component;
use App\Models\Site;
use App\Models\Poh;
use App\Models\DayOf;
use Carbon\Carbon;
use Auth;
use App\Models\BigLeave;
use App\Models\BigLeaveClaim;
use App\Models\BigLeaveCounter;
use App\Models\PohBigLeave;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Rules;
class AddBigLeave extends Component
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
    public $annualLeaveStandart;
    public $annualLeaveSum;
    public $annualLeaveStartDate;
    public $annualLeaveEndDate;

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

    public $updateTicketDateFromBack;

    public $numberBigLeaveClaim;

    protected $listeners = [
        'selectBigLeaveStartDate'=>'getSelectBigLeaveStartDate',
        'selectBigLeaveEndDate'=>'getSelectBigLeaveEndDate',
        'selectTicketDateFromBack'=>'getSelectTicketDateFromBack',
        'selectTravelDateFromBack'=>'getSelectTravelDateFromBack',
    ];

    protected $validationAttributes = [
        'bigLeaveStartDate' => 'Tanggal mulai',
        'bigLeaveEndDate' => 'Tanggal akhir',
        'ticketDateFromBack'=>'Tanggal tiket kembali',
        'travelDateFromBack'=>'Tanggal travel kembali',
    ];

    public function mount($id){
        $dateNows=Carbon::now();
        $years= $dateNows->year;
        $months= date('m',strtotime($dateNows));   
        $yearMonths=date('Y',strtotime($years)).'/'.$months;
        $countChecks=DayOf::where('site_id',Auth::user()->site->id)->whereMonth('created_at',$months)->whereYear('created_at', $years)->count();
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
            
            $annualLeaves=AnnualLeave::where('day_of_id',$dayOfs->id)->where('active','1')->latest()->first();
            if($annualLeaves){
                $this->annualLeaveStartDate = date('d/m/Y',strtotime($annualLeaves->start));
                $this->annualLeaveEndDate = date('d/m/Y',strtotime($annualLeaves->end));
                $this->annualLeaveSum = $annualLeaves->sum;
                $this->annualLeaveStandart = $annualLeaves->standart;
                $this->annualLeavelLess =$annualLeaves->less;

                if($annualLeaves->end!='' or $annualLeaves->end!=null){
                    $this->bigLeaveStartDate =   date('d/m/Y', strtotime(str_replace('/', '-',$annualLeaves->end). ' + '.$this->addDay.' days')); 
                }else{
                    $this->bigLeaveStartDate =   date('d/m/Y', strtotime(str_replace('/', '-',$dayOfs->end). ' + '.$this->addDay.' days'));
                }

            }

            $pohBigLeaves=PohBigLeave::where('site_id', $this->site)->where('poh_id', $this->poh)->where('active','1')->latest()->first();
            if($pohBigLeaves){
                $this->bigLeaveStandartDay=$pohBigLeaves->day_of;
            }
            $employees=User::find($this->employeeId);

            $bigLeaveCounters=bigLeaveCounter::where('user_id', $this->employeeId)->latest()->first();

            if($employees){
                if($bigLeaveCounters!=null){
                    $this->onSiteDate=$bigLeaveCounters->first_date;
                    $this->expireCheck=yearCalculate(date('Y-m-d',strtotime($bigLeaveCounters->first_date)));
                }else{
                    $this->onSiteDate=$employees->join_date;
                    $this->expireCheck=yearCalculate(date('Y-m-d',strtotime($employees->join_date)));
                } 
            }

            if($bigLeaveCounters){
                if($bigLeaveCounters->less>0){
                    //2 = 2 tahun yg merupakan expire cuti tahunan
                    if($this->expireCheck<=5){
                            $this->bigLeaveLess=$bigLeaveCounters->less;
                            $this->bigLeaveShouldDay=$this->bigLeaveLess;
                    }else{
                        $this->bigLeaveLess=0;
                        $this->bigLeaveShouldDay=$this->bigLeaveStandartDay;
                    }
                }else{
                    $this->bigLeaveLess=0;
                }
            }else{
                $this->bigLeaveShouldDay=$this->bigLeaveStandartDay;
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
            
            
            $dateNows=Carbon::now();
            $years= $dateNows->year;
            $months= date('m',strtotime($dateNows));   
            $yearMonths=date('Y',strtotime($years)).'/'.$months;

            $countBigLeaveChecks=BigLeaveClaim::where('site_id',$this->employeeId)->whereMonth('created_at',$months)->whereYear('created_at', $years)->count();
            if($countBigLeaveChecks==0){
                $orders='1001';
                $this->numberBigLeaveClaim='RML-'.$dayOfs->site->code.'/'.'INV/'.$yearMonths.'/'.$orders;
            }else{
                $getOrderBigLeaveClaims=BigLeaveClaim::where('site_id',$this->employeeId)->whereMonth('created_at',$months)->whereYear('created_at', $years)->latest()->first();
                $orderBigLeaveClaims=(int)substr( $getOrderBigLeaveClaims->number,-4) + 1;
                $this->numberBigLeaveClaim='RML-'.$dayOfs->site->code.'/'.'INV/'.$yearMonths.'/'.$orderBigLeaveClaims;
            }

        }

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
        //dd($this->annualLeaveStartDate);
        $administrators=User::where('level','administrator')->where('active','1')->get();
        $this->bigLeaveStandartMax= date('d/m/Y', strtotime(str_replace('/', '-', $this->bigLeaveStartDate). ' + '.$this->bigLeaveShouldDay.' days - '.$this->addDay.' days'));
        $this->planDate =  date('d/m/Y', strtotime(str_replace('/', '-',$this->startDate).'-'.$this->dayOfStandartDayTravel.'days -'.$this->dayOfStandartDayTicket.'days'));
        return view('livewire.transaction.day-of.add-big-leave',compact('administrators'))->extends('layouts.app')->section('content');
    }

    public function store(){

        $this->validate();
        $planDateRep= str_replace('/', '-', $this->planDate); 
        $startDateRep= str_replace('/', '-', $this->startDate);
        $bigLeaveStartDateRep= str_replace('/', '-', $this->bigLeaveStartDate);
        $bigLeaveEndDateRep= str_replace('/', '-', $this->bigLeaveEndDate);   
        $ticketDateFromBackRep= str_replace('/', '-', $this->ticketDateFromBack);		
        $travelDateFromBackRep= str_replace('/', '-', $this->travelDateFromBack);
        $bigLeaveCalculate=CountDay($bigLeaveStartDateRep,$bigLeaveEndDateRep);  
        $inDateRep= str_replace('/', '-', $this->inDate);

        $dayOfTotalCalculate=  CountDay($startDateRep,$bigLeaveEndDateRep);
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

            $bigLeaves = new BigLeave();
            $bigLeaves->user_id = $this->employeeId;
            $bigLeaves->site_id = $this->site;
            $bigLeaves->poh_id = $this->poh;
            $bigLeaves->day_of_id = $this->dayOfId;
            $bigLeaves->year = date('Y', strtotime($bigLeaveStartDateRep));
            $bigLeaves->start = date('Y-m-d', strtotime($bigLeaveStartDateRep));
            $bigLeaves->end = date('Y-m-d', strtotime($bigLeaveEndDateRep));
            $bigLeaves->sum=$bigLeaveCalculate + $this->addDay;
            $bigLeaves->standart=$this->bigLeaveStandartDay;
            $bigLeaves->should=$this->bigLeaveStandartDay + $this->bigLeaveLess;
            $bigLeaves->less=($this->bigLeaveStandartDay +  $this->bigLeaveLess)-($bigLeaveCalculate + $this->addDay);
            $bigLeaves->less_before=null;
            $bigLeaves->approv='0';
            $bigLeaves->active = '1';
            $bigLeaves->take = '1';
            $bigLeaves->save();

            if($this->bigLeaveLess==0){
                $bigLeaveCounters = new BigLeaveCounter();
                $bigLeaveCounters->user_id =$this->employeeId;
                $bigLeaveCounters->site_id =$this->site;
                $bigLeaveCounters->year = date('Y', strtotime($bigLeaveStartDateRep));
                $bigLeaveCounters->day=$bigLeaveCalculate + $this->addDay;
                $bigLeaveCounters->standart=$this->bigLeaveStandartDay;
                $bigLeaveCounters->should=$this->bigLeaveStandartDay + $this->bigLeaveLess;
                $bigLeaveCounters->less=($this->bigLeaveStandartDay +  $this->bigLeaveLess)-($bigLeaveCalculate + $this->addDay);
                $bigLeaveCounters->less_before=null;
                $bigLeaveCounters->first_date = date('Y-m-d', strtotime($bigLeaveStartDateRep));
                $bigLeaveCounters->last_date = date('Y-m-d', strtotime($bigLeaveEndDateRep));
                $bigLeaveCounters->save();
            }else{
                $bigLeaveCounters = BigLeaveCounter::where('user_id',$this->employeeId)->where('less','>',0)->latest()->first();
                $bigLeaveCounters->day=$bigLeaveCalculate + $this->addDay;
                $bigLeaveCounters->standart=$this->bigLeaveStandartDay;
                $bigLeaveCounters->should=$this->bigLeaveStandartDay + $this->bigLeaveLess;
                $bigLeaveCounters->less=($this->bigLeaveStandartDay +  $this->bigLeaveLess)-($bigLeaveCalculate + $this->addDay);
                $bigLeaveCounters->less_before=null;
                $bigLeaveCounters->last_date = date('Y-m-d', strtotime($bigLeaveEndDateRep));
                $bigLeaveCounters->save();
            }

                $bigLeaveClaims = new BigLeaveClaim();
                $bigLeaveClaims->big_leave_id = $bigLeaves->id;
                $bigLeaveClaims->user_id = $this->employeeId;
                $bigLeaveClaims->site_id = $this->site;
                $bigLeaveClaims->number=$this->numberBigLeaveClaim;
                $bigLeaveClaims->year=date('Y', strtotime($bigLeaveStartDateRep));
                $bigLeaveClaims->idr=null;
                $bigLeaveClaims->multiplier_salary='1';
                $bigLeaveClaims->head_approv='0';
                $bigLeaveClaims->hrd_approv='0';
                $bigLeaveClaims->sm_approv='0';
                $bigLeaveClaims->approv='0';
                $bigLeaveClaims->paid='0';
                $bigLeaveClaims->active = '1';
                $bigLeaveClaims->save();

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
        $this->annualLeaveStandart=null;
        $this->annualLeaveSum=null;
        $this->annualLeaveStartDate=null;
        $this->annualLeaveEndDate=null;
        
        
        $this->bigLeaveLess=null;
        $this->bigLeaveStandartDay=null;
        $this->bigLeaveStartDate=null;
        $this->bigLeaveEndDate=null;
        
        $this->expireCheck=null;
        $this->onSiteDate=null;
        $this->onSiteDayCalculate=null;
        $this->bigLeaveShouldDay=null;
        $this->bigLeaveStandartMax=null;
        $this->updateTicketDateFromBack=null;

        $this->dayOfStandartDayTravel=null;
        $this->dayOfStandartDayTicket=null;
        $this->dayOfStandartSite=null;
        $this->dayOfStandartPoh=null;

        $this->numberBigLeaveClaim=null;
    }
    public function getSelectBigLeaveStartDate( $value) {
        $this->bigLeaveStartDate=$value;
    }

    public function getSelectBigLeaveEndDate( $value) {
        $this->bigLeaveEndDate=$value;  
        if($this->bigLeaveEndDate!='' or $this->bigLeaveEndDate!=null){
            $this->ticketDateFromBack =  date('d/m/Y', strtotime(str_replace('/', '-',$this->bigLeaveEndDate).'+'.$this->addDay.'days'));
            $this->travelDateFromBack =  date('d/m/Y', strtotime(str_replace('/', '-',$this->bigLeaveEndDate).'+'.$this->addDay.'days'));
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
            $this->ticketDateFromBackValidate='required|date_format:"d/m/Y"|after:bigLeaveEndDate';
        }else{
            $this->ticketDateFromBackValidate='nullable';
        }
        if($this->travelDateFromBack!=='' or $this->travelDateFromBack!==null){
            $this->travelDateFromBackValidate='required|date_format:"d/m/Y"|after:bigLeaveEndDate|before_or_equal:'.date("Y-m-d",strtotime(str_replace('/', '-', $this->inDate).'-'.$this->addDay.'days')); 
        }else{
            $this->travelDateFromBackValidate='nullable'; 
        }
        if($this->dayOfStandartDayTravel>0){
            $this->ticketDateFromBackValidate='required|date_format:"d/m/Y"|after:bigLeaveEndDate';
            $this->travelDateFromBackValidate='required|date_format:"d/m/Y"|after:bigLeaveEndDate|before_or_equal:'.date("Y-m-d",strtotime(str_replace('/', '-', $this->inDate).'-'.$this->addDay.'days')); 
        }else{
            $this->ticketDateFromBackValidate='nullable';
            $this->travelDateFromBackValidate='nullable';            
        }
        return[  
            'bigLeaveStartDate'=>'required|date_format:"d/m/Y"|after:endDate',	
            'bigLeaveEndDate'=>'required|date_format:"d/m/Y"|after_or_equal:bigLeaveStartDate|before_or_equal:'.$this->bigLeaveStandartMax,
            'ticketDateFromBack'=>$this->ticketDateFromBackValidate,
            'travelDateFromBack'=>$this->travelDateFromBackValidate,
        ];
    }
    public function messages(){
        return  [
            'required' => ':attribute wajib diisi!',
            'bigLeaveEndDate.date_format'=>':attribute harus menggunakan format dd/mm/yyyy',
            'bigLeaveEndDate.after_or_equal'=>':attribute harus sama atau lebih dari tgl mulai cuti tahunan',
            'bigLeaveEndDate.before_or_equal'=>':attribute tdk boleh lebih dari tgl '.$this->bigLeaveStandartMax,
            'ticketDateFromBack.after'=>':attribute harus lebih dari tgl selesai cuti jobsite',
            
            'travelDateFromBack.date_format'=>':attribute harus menggunakan format dd/mm/yyyy',
            'travelDateFromBack.after'=>':attribute harus lebih dari tgl selesai cuti jobsite',
            'travelDateFromBack.before_or_equal'=>':attribute tdk boleh lebih dari tgl '.date("d/m/Y",strtotime(str_replace('/', '-', $this->onSiteDate).'-'.$this->addDay.'days')),
        ];
    }
 

}