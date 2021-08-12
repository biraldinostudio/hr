<?php

namespace App\Http\Livewire\Master\Poh;
use Livewire\Component;
use App\Models\Poh;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    //public $data;
    public $name;
    protected $rules = [
        'name' => 'required|min:4|max:50|unique:pohs',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'unique' => 'POH ini sudah ada!',
    ];

    protected $validationAttributes = [
        'name' => 'Nama POH',
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
        return view('livewire.master.poh.create');
    }
    public function store(){
       // dd($this->province);
        $this->validate();
        DB::beginTransaction();
        try{
            $pohs = new Poh;
            $pohs->name = $this->name;
            $pohs->active = '1';
            $pohs->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->emit('closeModal','createModal');
            $this->emit('reloadPohs');
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