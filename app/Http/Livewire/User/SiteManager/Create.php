<?php

namespace App\Http\Livewire\User\SiteManager;
use Livewire\Component;
use App\Models\Site;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    public $site='';
    public $employee='';

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
        'employee' => 'Site manager',
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
        $sites=Site::select('id','name')->where('active','1')->get();
        $employees=User::select('id','site_id','name')->where('staff','1')->whereIn('level',['employee','hrd_head','department_head'])->where('active','1')->get();
        return view('livewire.user.site-manager.create',compact('employees','sites'))->extends('layouts.app')->section('content');
    }

    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $employees = User::whereId($this->employee)->first();
            $employees->level='site_manager';
            $employees->save();            
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','createModal');
            $this->emit('reloadSiteManagers');
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
        $this->employee=null;
    }

    public function getSelectedSite($value) {
        $this->site = $value;
    }
    public function getSelectedEmployee($value) {
        $this->employee = $value;
    }

}