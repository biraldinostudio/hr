<?php

namespace App\Http\Livewire\Transaction\Permission;

use Livewire\Component;
use App\Models\Permission;
use App\Models\ApprovalRecord;
use App\Models\PermissionCategory;

class Detail extends Component
{
    public $number;
    public $employeeId;
    public $permissionId; 
    public $nrp;
    public $name;
    public $position;
    public $department;
    public $site;
    public $address;
    public $phone;
    public $startDate;
    public $endDate;
    public $inDate;
    public $sumDay;
    public $cutDayOf;
    public $description;

    public $permissionCategoryType;
    public $permissionCategoryName;

    public function mount($id){
        $permissions=Permission::find($id);
        $this->permissionId=$permissions->id;
        $this->number=$permissions->number;
        $this->employeeId=$permissions->user->id;
        $this->nrp=$permissions->user->nrp;
        $this->name=$permissions->user->name;
        $this->position=$permissions->user->position->name;
        $this->department=$permissions->user->position->department->name;
        $this->site=$permissions->user->site->name;
        $this->address=$permissions->user->address;
        $this->phone=$permissions->user->phone;
        $this->startDate=$permissions->start_date;
        $this->endDate=$permissions->end_date;
        $this->inDate=$permissions->in_date;
        $this->sumDay=$permissions->sum_day;
        $this->description=$permissions->description;

        $permissionCategories=PermissionCategory::where('id',$permissions->permission_category_id)->first();
        $this->permissionCategoryType=$permissionCategories->type;
        $this->permissionCategoryName=$permissionCategories->name;
        $this->initializedProperties();
    }
 

    public function render(){
        $approvalRecords=ApprovalRecord::select('a.head_approv','a.hrd_approv','a.sm_approv','a.approv','c.level as level_approv','c.nrp','c.name as approver','c.hr_head','approval_records.level as level_order','approval_records.reason','approval_records.created_at')
        ->leftjoin('permissions as a', 'a.id', '=', 'approval_records.doc')
        ->join('users as b', 'b.id', '=', 'a.user_id')  
        ->leftjoin('users as c', 'c.id', '=', 'approval_records.user_id')        
        ->where('approval_records.doc',$this->permissionId)->where('approval_records.type','izin')->get();   
        return view('livewire.transaction.permission.detail',compact('approvalRecords'))->extends('layouts.app')->section('content');
    }
    private function initializedProperties(){
        $this->employeeId;
        $this->permissionId;
        $this->nrp;
        $this->name;
        $this->position;
        $this->department;
        $this->site;
        $this->address;
        $this->phone;
        $this->startDate;
        $this->endDate;
        $this->inDate;
        $this->sumDay;
        $this->cutDayOf;
        $this->description;
        $this->permissionCategoryType;
        $this->permissionCategoryName;
    }
    
    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
       // $this->emit('closeModalPermission','modal_detail_permission');
    }
}
