<?php

namespace App\Http\Livewire\Amenities\LumpSum;

use App\Models\Lumpsum;
use Livewire\Component;
use App\Models\Site;
use App\Models\Poh;
use App\MOdels\Department;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
class Update extends Component
{
    public $lumpsumId;    
    public $site;
    public $poh='';
    public $department='';
    public $position='';
    public $idr;
    public $idrStaff;
    public $status;
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'max' => ':attribute maksimal :max karakter!',
        'numeric'=>':attribute format harus angka',
        'digits_between'=>':attribute 1 s/d 2 karakter',
        'not_in'=>':attribute tidak boleh angka 0',
        'unique'=>'Data ini sudah ada!',
    ];

    protected $validationAttributes = [
        'site' => 'Site',
        'poh' => 'POH',
        'department' => 'Departemen',
        'position' => 'Jabatan',
        //'dayof' => 'Hari Cuti',
        //'travel' => 'Hari Travel',
        'idr' => 'Lump Sum (Non Staff)',
        'idrStaff' => 'Lump Sum (Staff)',
    ];

    public function mount($id){
        $lumpsum=Lumpsum::find($id);
        if($lumpsum){
            $this->lumpsumId=$lumpsum->id;
            $this->site=$lumpsum->site->id;
            $this->poh=$lumpsum->poh->id;
            $this->department=$lumpsum->position->department->id;
            $this->position=$lumpsum->position->id;
            $this->idr=currency_IDR($lumpsum->idr);
            $this->idrStaff=currency_IDR($lumpsum->idr_staff);
            $this->status=$lumpsum->active;
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
        $lumpsums=Lumpsum::where('id',$this->lumpsumId)->first();
        $sites=Site::select('id','name')->where('active','1')->get();
        $pohs=Poh::select('id','name')->where('active','1')->get();
        $departments=Department::select('id','name')->where('active','1')->get();
        $positions=Position::select('id','department_id','name')->where('active','1')->get();
        return view('livewire.amenities.lump-sum.update',compact('lumpsums','sites','pohs','departments','positions'))->extends('layouts.app')->section('content');
    }

    public function update(){
        $this->validate();
        DB::beginTransaction();
        try{
            $lumpsums = Lumpsum::whereId($this->lumpsumId)->first();
            $lumpsums->site_id = $this->site;
            $lumpsums->poh_id = $this->poh;
            $lumpsums->position_id = $this->position;
            $lumpsums->idr = currencyIDRToNumeric($this->idr);
            $lumpsums->idr_staff = currencyIDRToNumeric($this->idrStaff);
            $lumpsums->active = $this->status;
            $lumpsums->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Update Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('reloadLumpSums');
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
            'site'=>'required',
            'poh' => 'required',
            'department' => 'required',
            'position' => 'required',
            'idr' => 'required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
            'idrStaff' => 'required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
        ];
    }
    private function initializedProperties(){
        $this->site;
        $this->poh;
        $this->department;
        $this->position;
        $this->idr=null;
        $this->idrStaff=null;
        $this->status=null;
    }
}