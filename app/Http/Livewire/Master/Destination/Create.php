<?php

namespace App\Http\Livewire\Master\Destination;
use Livewire\Component;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    //public $data;
    public $name;
    protected $rules = [
        'name' => 'required|min:4|max:50|unique:destinations',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'unique' => 'Destinasi ini sudah ada!',
    ];

    protected $validationAttributes = [
        'name' => 'Nama Destinasi',
    ];

    public function mount(){
        $this->initializedProperties();
    }

    //Real time validate
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


    public function render(){
        return view('livewire.master.destination.create');
    }
    public function store(){
       // dd($this->province);
        $this->validate();
        DB::beginTransaction();
        try{
            $destinations = new Destination();
            $destinations->name = $this->name;
            $destinations->active = '1';
            $destinations->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->emit('closeModal','createModal');
            $this->emit('reloadDestinations');
            $this->initializedProperties();
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
        $this->name=null;
    }
}