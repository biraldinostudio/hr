<?php

namespace App\Http\Livewire\Amenities\PohAnnualLeave;

use App\Models\PohAnnualLeave;
use Livewire\Component;
use App\Models\Site;
use App\Models\Poh;
use Illuminate\Support\Facades\DB;
class Update extends Component
{
    public $pohAnnualLeaveId;    
    public $site;
    public $poh='';
    public $dayof;
    public $status;
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

    public function mount($id){
        $pohAnnualLeaves=PohAnnualLeave::find($id);
        if($pohAnnualLeaves){
            $this->pohAnnualLeaveId=$pohAnnualLeaves->id;
            $this->site=$pohAnnualLeaves->site->id;
            $this->poh=$pohAnnualLeaves->poh->id;
            $this->dayof=$pohAnnualLeaves->day_of;
            $this->status=$pohAnnualLeaves->active;
        }
    }
    
    public function updated($property, $value){
        if(trim($value)){
            $this->validateOnly($property);
        }else{
            $this->resetErrorBag($property);
        }
    }
/*
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }*/


    public function render(){
        $pohAnnualLeaves=PohAnnualLeave::where('id',$this->pohAnnualLeaveId)->first();
        $sites=Site::select('id','name')->where('active','1')->get();
        $pohs=Poh::select('id','name')->where('active','1')->get();
        return view('livewire.amenities.poh-annual-leave.update',compact('pohAnnualLeaves','sites','pohs'))->extends('layouts.app')->section('content');
    }

    public function update(){
     // dd($this->department,$this->position);
        $this->validate();
        DB::beginTransaction();
        try{
            $pohAnnualLeaves = PohAnnualLeave::whereId($this->pohAnnualLeaveId)->first();
            $pohAnnualLeaves->site_id = $this->site;
            $pohAnnualLeaves->poh_id = $this->poh;
            $pohAnnualLeaves->day_of = $this->dayof;
            $pohAnnualLeaves->active = $this->status;
            $pohAnnualLeaves->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Update Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('reloadPohAnnualLeaves');
            //$this->initializedProperties();
           //return redirect()->route('annualleave');
        }catch(\Throwable $th){
            DB::rollBack();
            $errorCode = $th->errorInfo[1];
            if($errorCode == '1062'){
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Update Data',
                    'message'=>'Data ini sudah ada, silahkan masukan data yang lain!'
                ]);
            }else{
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Update Data',
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

    public function rules (){
        return[
            'site' => 'required',
            'poh' => 'required',       
            'dayof' => 'required|numeric|digits_between:1,2|not_in:0',
        ];
    }

    private function initializedProperties(){
        $this->site;
        $this->poh;
        $this->dayof=null;
        $this->status=null;
    }
}