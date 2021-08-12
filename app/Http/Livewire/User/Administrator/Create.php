<?php

namespace App\Http\Livewire\User\Administrator;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    public $employee='';

    protected $listeners = [
        "selectEmployee" => 'getSelectedEmployee'
    ];

    protected $rules = [
        'employee' => 'required',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
    ];

    protected $validationAttributes = [
        'employee' => 'Administrator',
    ];

    public function mount(){
        $this->initializedProperties();
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function render(){
        $this->emit('resetSelect2');
        $employees=User::select('id','site_id','position_id','nrp','name')->where('staff','1')->whereIn('level',['employee','hrd_head','department_head'])->where('active','1')->get();
        return view('livewire.user.administrator.create',compact('employees'))->extends('layouts.app')->section('content');
    }

    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $employees = User::whereId($this->employee)->first();
            $employees->level='administrator';
            $employees->save();            
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','createModal');
            $this->emit('reloadAdministrators');
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
        $this->employee=null;
    }

    public function getSelectedEmployee($value) {
        $this->employee = $value;
    }

}