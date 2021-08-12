<?php

namespace App\Http\Livewire\User\DepartmentHead;

use App\Models\Department;
use Livewire\Component;
use App\Models\Site;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    public $site='';
    public $department='';
    public $employee='';
    public $getSuggestNRP='';
    public $getSuggestName='';
    public $getSuggestPosition='';
    public $getSuggestDepartment='';

    protected $listeners = [
        "selectSite" => 'getSelectedSite',
        "selectEmployee" => 'getSelectedEmployee'
    ];

    protected $rules = [
        'site' => 'required',
        'employee' => 'required',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
    ];

    protected $validationAttributes = [
        'site' => 'Job Site',
        'department' => 'Departemen',
        'employee' => 'Department Head',
    ];

    public function mount(){
        $this->initializedProperties();
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $suggest=User::select('id','position_id','nrp','name')->where('id',$this->employee)->first();
        if($suggest!=''){
            $this->getSuggestNRP=$suggest->nrp;
            $this->getSuggestName=$suggest->name;
            $this->getSuggestPosition=$suggest->position->name;
            $this->getSuggestDepartment=$suggest->position->department->name;
        }

    }
    public function render(){
        $this->emit('resetSelect2');
        $sites=Site::select('id','name')->where('active','1')->get();
        $departments=Department::select('id','name')->where('active','1')->get();
        $employees=User::select('id','site_id','name')->where('staff','1')->whereIn('level',['employee','site_manager'])->where('active','1')->get();
        return view('livewire.user.department-head.create',compact('employees','sites','departments'))->extends('layouts.app')->section('content');
    }

    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $employees = User::whereId($this->employee)->first();
            $employees->level='department_head';
            $employees->save();            
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','createModal');
            $this->emit('reloadDepartmentHeads');
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
        $this->site=null;
        $this->department=null;
        $this->employee=null;
        $this->getSuggestNRP=null;
        $this->getSuggestName=null;
        $this->getSuggestPosition=null;
        $this->getSuggestDepartment=null;
    }

    public function getSelectedSite($value) {
        $this->site = $value;
    }

    public function getSelectedEmployee($value) {
        $this->employee = $value;
    }

}