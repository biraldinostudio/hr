<?php

namespace App\Http\Livewire\Transaction\Permission;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\PermissionCategory;
use App\Models\PermissionDebt;
use Auth;
class Update extends Component
{
    public $permissionId;
    public $startDate='';
    public $endDate='';
    public $inDate='';
    public $description='';
    public $status='';
    public $addDay=1;

    public $permissionCategory='';
    public $permissionCategoryOfficial;
    public $permissionCategoryType;
    public $permissionCategoryName;

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

    public function mount($id){
        $permissions=Permission::find($id);
        $this->permissionId=$permissions->id;
        $this->permissionCategory=$permissions->permission_category_id;
        $this->startDate = date('d/m/Y',strtotime($permissions->start_date));
        $this->endDate = date('d/m/Y',strtotime($permissions->end_date));
        $this->inDate = date('d/m/Y',strtotime($permissions->in_date));
        $this->description=$permissions->description;
        $this->status=$permissions->active;





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
        //dd($this->permissionCategoryType);
        $permissionCategories=PermissionCategory::where('active','1')->get();
        return view('livewire.transaction.permission.update',compact('permissionCategories'))->extends('layouts.app')->section('content');
    }

   public function update(){
    $permissionCategories=PermissionCategory::where('id',$this->permissionCategory)->first();
    if($permissionCategories){
        $this->permissionCategoryOfficial=$permissionCategories->official;
        $this->permissionCategoryType=$permissionCategories->type;
    }
      // dd($this->permissionCategoryType);
        $this->validate();
        $startDateRep= str_replace('/', '-', $this->startDate);
        $endDateRep= str_replace('/', '-', $this->endDate); 
        $inDateRep= str_replace('/', '-', $this->inDate); 
        $sumDays=CountDay($startDateRep,$endDateRep);

        DB::beginTransaction();
        try{
            $permissions = Permission::whereId($this->permissionId)->first();
            $permissions->permission_category_id=$this->permissionCategory;
            $permissions->start_date = date('Y-m-d', strtotime($startDateRep));
            $permissions->end_date = date('Y-m-d', strtotime($endDateRep));
            $permissions->in_date = date('Y-m-d', strtotime($inDateRep));
            $permissions->sum_day=$sumDays + $this->addDay;	
            $permissions->description=$this->description;
            $permissions->active = $this->status;
            $permissions->save();
            
            $permissionDebChecks=PermissionDebt::where('permission_id',$this->permissionId)->first();
            if($permissionDebChecks!=null){
                if($this->permissionCategoryType=='Official'){
                    PermissionDebt::where('permission_id',$this->permissionId)->delete();

                }           
                if($this->permissionCategoryType=='CutAnnualLeave'){
                    $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                    $permissionDebts->year = date('Y', strtotime($startDateRep));
                    $permissionDebts->date = date('Y-m-d', strtotime($startDateRep));
                    $permissionDebts->sum_day=$sumDays + $this->addDay;
                    $permissionDebts->less_day=$sumDays + $this->addDay;	                
                    $permissionDebts->for='AnnualLeave';
                    $permissionDebts->active = $this->status;
                    $permissionDebts->save();

                }

                if($this->permissionCategoryType=='CutBasicSalary'){
                    $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                    $permissionDebts->year = date('Y', strtotime($startDateRep));
                    $permissionDebts->date = date('Y-m-d', strtotime($startDateRep));
                    $permissionDebts->sum_day=$sumDays + $this->addDay;
                    $permissionDebts->less_day=$sumDays + $this->addDay;	                
                    $permissionDebts->for='BasicSalary';
                    $permissionDebts->active = $this->status;
                    $permissionDebts->save();
                }
            }else{
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
                    $permissionDebts->active = '1';
                    $permissionDebts->save();
                }
            }


            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Ubah Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            session()->flash('message', 'Berhasil ubah data!');
            $this->initializedProperties();
            redirect()->route('my-permission');
           
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

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }

    private function initializedProperties(){
        $this->startDate;
        $this->endDate;
        $this->inDate;
        $this->description;
        $this->status;

        $this->permissionCategory;
        //$this->permissionCategoryOfficial;
        //$this->permissionCategoryType;
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
