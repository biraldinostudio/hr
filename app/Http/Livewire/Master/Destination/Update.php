<?php

namespace App\Http\Livewire\Master\Destination;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Destination;
class Update extends Component
{
    public $destinationId;
    public $name;
    public $status;
    protected $listeners=[
        'updateDestination'=>'showModal'
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'unique' => 'Destinasi ini sudah ada!',
    ];

    protected $validationAttributes = [
        'name' => 'Nama Destinasi',
        'status' => 'Status Destinasi'
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
        return view('livewire.master.destination.update');
    }

    public function showModal(Destination $destination){
        $this->destinationId=$destination->id;
        $this->name=$destination->name;
        $this->status=$destination->active;
        $this->emit('showModal','editModal');
    }

   public function update(){
        $this->validate();
        DB::beginTransaction();
        try{
            $destinations = Destination::whereId($this->destinationId)->first();
            $destinations->name = $this->name;
            $destinations->active = $this->status;
            $destinations->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Ubah Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('closeModal','editModal');
            $this->emit('reloadDestinations');
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
            'name' => 'required|min:4|max:50|unique:destinations,name,'.$this->destinationId,
            'status'=>'required',
        ];
    }

    private function initializedProperties(){
        $this->name=null;
        $this->status=null;
    }
}
