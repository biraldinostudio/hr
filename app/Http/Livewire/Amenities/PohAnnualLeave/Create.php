<?php

namespace App\Http\Livewire\Amenities\PohAnnualLeave;

use App\Models\PohAnnualLeave;
use Livewire\Component;
use App\Models\Site;
use App\Models\Poh;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    public $site='';
    public $poh='';
    public $dayof;
    protected $rules = [
        'site' => 'required',
        'poh' => 'required',       
        'dayof' => 'required|numeric|digits_between:1,2|not_in:0',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'max' => ':attribute maksimal :max karakter!',
        'numeric'=>':attribute format harus angka',
        'digits_between'=>':attribute 1 s/d 2 karakter',
        'not_in'=>':attribute tidak boleh angka 0',
    ];

    protected $validationAttributes = [
        'site' => 'Site',
        'poh' => 'POH',
        'dayof' => 'Hari Cuti tahunan',
    ];

    public function mount(){
        $this->initializedProperties();
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

    public function render()
    {
        $sites=Site::select('id','name')->where('active','1')->get();
        $pohs=Poh::select('id','name')->where('active','1')->get();
        return view('livewire.amenities.poh-annual-leave.create',compact('sites','pohs'))->extends('layouts.app')->section('content');
    }

    public function store(){
     // dd($this->department,$this->position);
        $this->validate();   
        DB::beginTransaction();
        try{
            $employees = new PohAnnualLeave();
            $employees->site_id = $this->site;
            $employees->poh_id = $this->poh;
            $employees->day_of = $this->dayof;
            $employees->active = '1';
            $employees->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            //$this->clearForm();
            $this->initializedProperties();
            $this->emit('closeModal','createModal');
            $this->emit('reloadPohAnnualLeaves');
        }catch(\Throwable $th){
            DB::rollBack();
            $errorCode = $th->errorInfo[1];
            if($errorCode == '1062'){
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Create Data',
                    'message'=>'Data ini sudah ada, silahkan masukan data yang lain!'
                ]);
            }else{
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Create Data',
                    'message'=>'Error:'.$th->getMessage()
                ]);
            }
        }
        DB::commit();
    }
    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
    private function initializedProperties(){
        $this->site=null;
        $this->poh=null;
        $this->dayof=null;
    }
}
