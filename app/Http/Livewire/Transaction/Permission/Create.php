<?php

namespace App\Http\Livewire\Transaction\Permission;

use App\Models\Destination;
use Livewire\Component;
use App\Models\Permission;
use App\Models\PermissionCategory;
use App\Models\PermissionDebt;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
class Create extends Component
{
    public $number;
    public $startDate='';
    public $endDate='';
    public $inDate='';
    public $addDay=1;
    public $description='';
    public $permissionCategory='';
    public $permissionCategoryOfficial;
    public $permissionCategoryType;

    public $latestPermissionOpen;
    public $latestPermissionOpenNumber;
    //public $type='';
    protected $listeners = [
         'selectStartDate'=>'getSelectedStartDate',
         'selectEndDate'=>'getSelectedEndDate',
         'selectInDate'=>'getSelectedInDate',
         'selectPermissionCategory'=>'getSelectedPermissionCategory'
     ];
 
     protected $validationAttributes = [
         'startDate'=>'Tgl mulai izin',
         'endDate'=>'Tgl akhir izin',
         'description'=>'Keterangan izin',
         'permissionCategory'=>'Jenis izin',
     ];
 
     public function mount(){
 
         //Bagian nomor dokumen
         $dateNows=Carbon::now();
         $years= $dateNows->year;
         $months= date('m',strtotime($dateNows));   
         $yearMonths=date('Y',strtotime($years)).'/'.$months;
         $countChecks=Permission::where('site_id',Auth::user()->site->id)->whereMonth('created_at',$months)->whereYear('created_at', $years)->count();
         if($countChecks==0){
             $orders='1001';
             $this->number='RML-'.Auth::user()->site->code.'/'.'IZ/'.$yearMonths.'/'.$orders;
         }else{
             $getOrders=Permission::where('site_id',Auth::user()->site->id)->whereMonth('created_at',$months)->whereYear('created_at', $years)->latest()->first();
             $orders=(int)substr( $getOrders->number,-4) + 1;
             $this->number='RML-'.Auth::user()->site->code.'/'.'IZ/'.$yearMonths.'/'.$orders;
         }

         $latestPermissionOpens=Permission::where('user_id',Auth::user()->id)->where('approv','0')->where('active','1')->latest()->first();
      
         if(!empty($latestPermissionOpens)){
             $this->latestPermissionOpen=$latestPermissionOpens->count();
             $this->latestPermissionOpenNumber=$latestPermissionOpens->number;
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
    
    public function render(){
        //$destinations=Destination::where('active','1')->get();
      
        $permissionCategories=PermissionCategory::where('active','1')->get();
        return view('livewire.transaction.permission.create',compact('permissionCategories'));
    }

    public function store(){
        $permissionCategories=PermissionCategory::where('id',$this->permissionCategory)->first();
        if($permissionCategories){
            $this->permissionCategoryOfficial=$permissionCategories->official;
            $this->permissionCategoryType=$permissionCategories->type;
        }
        //dd($this->permissionCategoryType);
       $this->validate();
        $startDateRep= str_replace('/', '-', $this->startDate);
        $endDateRep= str_replace('/', '-', $this->endDate); 
        $inDateRep= str_replace('/', '-', $this->inDate); 
        $sumDays=CountDay($startDateRep,$endDateRep);
       DB::beginTransaction();
        try{
            
		    $permissions = new Permission();
            $permissions->user_id = Auth::user()->id;
            $permissions->site_id = Auth::user()->site->id;
            $permissions->permission_category_id = $this->permissionCategory;
            $permissions->number=$this->number;
            $permissions->start_date = date('Y-m-d', strtotime($startDateRep));
            $permissions->end_date = date('Y-m-d', strtotime($endDateRep));
            $permissions->in_date = date('Y-m-d', strtotime($inDateRep));
            $permissions->sum_day=$sumDays + $this->addDay;	
            $permissions->description=$this->description;
           // $permissions->type=$this->type;            
            $permissions->head_approv='0';
            $permissions->hrd_approv='0';
            $permissions->sm_approv='0';
            $permissions->active = '1';
            $permissions->save();
            if($this->permissionCategoryType=='CutAnnualLeave'){
                $permissionDebts=new PermissionDebt();
                $permissionDebts->permission_id = $permissions->id;                
                $permissionDebts->user_id = Auth::user()->id;
                $permissionDebts->site_id = Auth::user()->site->id;
                $permissionDebts->year = date('Y', strtotime($startDateRep));
                $permissionDebts->date = date('Y-m-d', strtotime($startDateRep));
                $permissionDebts->sum_day=$sumDays + $this->addDay;
                $permissionDebts->less_day=$sumDays + $this->addDay;	                
                $permissionDebts->for='AnnualLeave';
                $permissionDebts->approv='0';
                $permissionDebts->active = '1';
                $permissionDebts->save();

            }

            if($this->permissionCategoryType=='CutBasicSalary'){
                $permissionDebts=new PermissionDebt();
                $permissionDebts->permission_id = $permissions->id;                
                $permissionDebts->user_id = Auth::user()->id;
                $permissionDebts->site_id = Auth::user()->site->id;
                $permissionDebts->year = date('Y', strtotime($startDateRep));
                $permissionDebts->date = date('Y-m-d', strtotime($startDateRep));
                $permissionDebts->sum_day=$sumDays + $this->addDay;
                $permissionDebts->less_day=$sumDays + $this->addDay;	                
                $permissionDebts->for='BasicSalary';
                $permissionDebts->approv='0';
                $permissionDebts->active = '1';
                $permissionDebts->save();
            }
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','createModal');
            $this->emit('reloadPermissions');
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
        $this->emit('closeModal','createModal');
    }
    private function initializedProperties(){
        $this->number;
        $this->startDate=null;
        $this->endDate=null;
        $this->inDate=null;
        $this->description=null;
        //$this->type=null;
        $this->permissionCategory=null;
        $this->permissionCategoryOfficial;
        $this->permissionCategoryType;

        $this->latestPermissionOpen;
        $this->latestPermissionOpenNumber;
        
    }

    public function getSelectedStartDate($value) {
        $this->startDate=$value;
        if( $this->startDate==null){
            $this->endDate= $this->startDate;
            $this->inDate= $this->startDate;
        }
    }
    public function getSelectedEndDate($value) {
        $this->endDate=$value;
        if($this->endDate!=null or $this->endDate!=''){
            $this->inDate =  date('d/m/Y', strtotime(str_replace('/', '-',$this->endDate).'+'.$this->addDay.'days'));
        }else{
            $this->inDate=$this->endDate;
        }
    }

    public function getSelectedInDate($value) {
        $this->inDate=$value;
    }

    public function getSelectedPermissionCategory($value) {
        $this->permissionCategory=$value;
    }

    public function rules (){
        return [
            'permissionCategory'=>'required',
            'startDate' => 'required|date_format:"d/m/Y"|after:'.date("d/m/Y"),
            'endDate' => 'required|date_format:"d/m/Y"|after_or_equal:startDate',
            'description' => 'required|min:10|max:500',
        ];
    }

    public function messages(){
        return [
            'required' => ':attribute wajib diisi!',
            'startDate.after'=>':attribute harus lebih dari tgl hari ini',
            'endDate.after_or_equal'=>':attribute harus lebih atau sama dengan tgl mulai',
            'startDate.date_format'=>':attribute menggunakan format d/m/Y',
            'endDate.date_format'=>':attribute menggunakan format d/m/Y',
            'min'=>':attribute minimal :min karakter',
            'max'=>':attribute maksimal :max karakter',
        ];
    }
 }
