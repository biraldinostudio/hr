<?php

namespace App\Http\Livewire\Amenities\LumpSum;

use Livewire\Component;
use App\Models\Lumpsum;
use App\Models\Site;
use App\Models\Poh;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    public $site='';
    public $poh='';
    public $department='';
    public $position='';
    public $idr;
    public $idrStaff;
    /*protected $rules = [
        'site' => 'required',
        'poh' => 'required',
        'department' => 'required',
        'position' => 'required',        
        'idr' => 'required|min:6|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
    ];*/
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
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
        'idr' => 'Lump Sum (Non Staff)',
        'idrStaff' => 'Lump Sum (Staff)',
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
        $departments=Department::select('id','name')->where('active','1')->get();
        $positions=Position::select('id','name')->where('active','1')->get();
        return view('livewire.amenities.lump-sum.create',compact('sites','pohs','departments','positions'))->extends('layouts.app')->section('content');
    }

    public function store(){
     //dd($this->idr,currencyIDRToNumeric($this->idr));
        $this->validate();   
        DB::beginTransaction();
        try{
            $lumpsums = new Lumpsum();
            $lumpsums->site_id = $this->site;
            $lumpsums->poh_id = $this->poh;
            $lumpsums->position_id = $this->position;
            $lumpsums->idr = currencyIDRToNumeric($this->idr);
            $lumpsums->idr_staff = currencyIDRToNumeric($this->idrStaff);
            $lumpsums->active = '1';
            $lumpsums->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','createModal');
            $this->emit('reloadLumpSums');
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
        $this->poh=null;
        $this->department=null;
        $this->position=null;
        $this->idr=null;
        $this->idrStaff=null;
    }

    public function rules (){
        return[
            'site'=> 'unique:lumpsums,site_id,NULL,id,poh_id,'.$this->poh.',position_id,'.$this->position.'|required',
            'poh' => 'required',
            'department' => 'required',
            'position' => 'required',        
            'idr' => 'required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
            'idrStaff' => 'required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
        ];
    }
    
}
