<?php

namespace App\Http\Livewire\Amenities\PohBigLeave;

use App\Models\PohBigLeave;
use Livewire\Component;
use App\Models\Site;
use App\Models\Poh;
use Illuminate\Support\Facades\DB;
class Update extends Component
{
    public $pohBigLeaveId;    
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
        'dayof' => 'Hari Cuti besar',
    ];

    public function mount($id){
        $pohBigLeaves=PohBigLeave::find($id);
        if($pohBigLeaves){
            $this->pohBigLeaveId=$pohBigLeaves->id;
            $this->site=$pohBigLeaves->site->id;
            $this->poh=$pohBigLeaves->poh->id;
            $this->dayof=$pohBigLeaves->day_of;
            $this->status=$pohBigLeaves->active;
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
        $pohBigLeaves=PohBigLeave::where('id',$this->pohBigLeaveId)->first();
        $sites=Site::select('id','name')->where('active','1')->get();
        $pohs=Poh::select('id','name')->where('active','1')->get();
        return view('livewire.amenities.poh-big-leave.update',compact('pohBigLeaves','sites','pohs'))->extends('layouts.app')->section('content');
    }

    public function update(){
     // dd($this->department,$this->position);
        $this->validate();
        DB::beginTransaction();
        try{
            $pohBigLeaves = PohBigLeave::whereId($this->pohBigLeaveId)->first();
            $pohBigLeaves->site_id = $this->site;
            $pohBigLeaves->poh_id = $this->poh;
            $pohBigLeaves->day_of = $this->dayof;
            $pohBigLeaves->active = $this->status;
            $pohBigLeaves->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Update Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('reloadPohBigLeaves');
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