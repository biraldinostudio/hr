<?php

namespace App\Http\Livewire\Master\Poh;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Poh;
class Update extends Component
{
    public $pohId;
    public $name;
    public $status;
    protected $listeners=[
        'updatePoh'=>'showModal'
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'unique' => 'POH ini sudah ada!',
    ];

    protected $validationAttributes = [
        'name' => 'Nama POH',
        'status' => 'Status POH'
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
        return view('livewire.master.poh.update');
    }

    public function showModal(Poh $poh){
        $this->pohId=$poh->id;
        $this->name=$poh->name;
        $this->status=$poh->active;
        $this->emit('showModal','editModal');
    }

   public function update(){
        $this->validate();
        DB::beginTransaction();
        try{
            $pohs = Poh::whereId($this->pohId)->first();
            $pohs->name = $this->name;
            $pohs->active = $this->status;
            $pohs->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Ubah Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('closeModal','editModal');
            $this->emit('reloadPohs');
            $this->initializedProperties();
           
        }catch(\Throwable $th){
            DB::rollBack();
            $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Ubah Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
        }
        DB::commit();
    }
    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }

    public function rules (){
        return[
            'name' => 'required|min:4|max:50|unique:pohs,name,'.$this->pohId,
            'status'=>'required',
        ];
    }

    private function initializedProperties(){
        $this->name=null;
        $this->status=null;
    }
}
