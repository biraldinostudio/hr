<?php

namespace App\Http\Livewire\Master\Site;
use Livewire\Component;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    public $code;
    public $name;
    protected $rules = [
        'code' => 'required|min:2|max:5|unique:sites',
        'name' => 'required|min:4|max:40|unique:sites',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'unique' => 'Kode / Nama Site ini sudah ada!',
    ];

    protected $validationAttributes = [
        'code' => 'Kode site',
        'name' => 'Nama site'
    ];

    public function mount(){
        $this->initializedProperties();
    }

    //Real time validate
    public function updated($property, $value){
        if(trim($value)){
            $this->validateOnly($property);
        }else{
            $this->resetErrorBag($property);
        }
    }

    public function render(){
        return view('livewire.master.site.create');
    }
    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $sites = new Site;
            $sites->code = $this->code;
            $sites->name = $this->name;
            $sites->active = '1';
            $sites->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->emit('closeModal','createModal');
            $this->emit('reloadSites');
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
        $this->code=null;
        $this->name=null;
    }
}
