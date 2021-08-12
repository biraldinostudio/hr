<?php

namespace App\Http\Livewire\Amenities\DayOfPeriod;

use Livewire\Component;
use App\Models\DayOfPeriod;
use Illuminate\Support\Facades\DB;
class Show extends Component
{
    public $staff;
    public $nonstaff;

    protected $listeners=[
        'reloadDayOfPeriods'=>'$refresh'
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'numeric'=>':attribute format harus angka',
        'digits_between'=>':attribute 1 s/d 2 karakter',
        'not_in'=>':attribute tidak boleh angka 0',
        'unique'=>'Data ini sudah ada!',
    ];

    protected $validationAttributes = [
        'staff' => 'Staff',
        'nonstaff' => 'Non Staff',
    ];
    public function mount(){
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
        $dayofperiods=DayOfPeriod::select('id','staff','day','created_at')->get();
        return view('livewire.amenities.day-of-period.show',compact('dayofperiods'))->extends('layouts.app')->section('content');
    }

    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $data = [
                ['staff'=>'1', 'day'=> $this->staff,'created_at'=>date('Y-m-d H:i:s')],
                ['staff'=>'0', 'day'=> $this->nonstaff,'created_at'=>date('Y-m-d H:i:s')],
            ];
            DayOfPeriod::insert($data);
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->emit('reloadDayOfPeriods');
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

    private function initializedProperties(){
        $this->staff=null;
        $this->nonstaff=null;
    }

    public function rules (){
        return[      
            'staff' => 'required|numeric|digits_between:1,2|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
            'nonstaff' => 'required|numeric|digits_between:1,2|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
        ];
    }    
}
