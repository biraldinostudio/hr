<?php

namespace App\Http\Livewire\Amenities\DayOfPeriod;

use App\Models\DayOfPeriod;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
class Update extends Component
{
    public $dayofperiodId;    
    public $day;
    public $staff;
    protected $listeners=[
        'updateDayOfPeriod'=>'showModal'
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'numeric'=>':attribute format harus angka',
        'digits_between'=>':attribute 1 s/d 2 karakter',
        'not_in'=>':attribute tidak boleh angka 0',
        'unique'=>'Data ini sudah ada!',
    ];

    protected $validationAttributes = [
        'day' => 'Periode',
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
/*
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }*/


    public function render(){
        return view('livewire.amenities.day-of-period.update');
    }

    public function showModal(DayOfPeriod $dayofperiod){
        $this->dayofperiodId=$dayofperiod->id;
        $this->staff=$dayofperiod->staff;
        $this->day=$dayofperiod->day;
        $this->emit('showModal','editModal');
    }

    public function update(){
        $this->validate();
        DB::beginTransaction();
        try{
            $dayofperiods = DayOfPeriod::whereId($this->dayofperiodId)->first();
            $dayofperiods->day = trim($this->day);
            $dayofperiods->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Update Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('closeModal','editModal');
            $this->emit('reloadDayOfPeriods');
            $this->initializedProperties();
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
            'day' => 'required|numeric|digits_between:1,2|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
        ];
    }
    private function initializedProperties(){
        $this->staff=null;
        $this->day=null;
    }
}