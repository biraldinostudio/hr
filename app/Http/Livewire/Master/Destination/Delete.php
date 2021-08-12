<?php

namespace App\Http\Livewire\Master\Destination;

use Livewire\Component;
use App\Models\Destination;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $destinationId;
    public $name;
    protected $listeners=[
        'deleteDestination'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.master.destination.delete');
    }

    public function showModal(Destination $destination){
        $this->destinationId=$destination->id;
        $this->name=$destination->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            Destination::whereId($this->destinationId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadDestinations');
            $this->initializedProperties();
        }catch(\Throwable $th){
            DB::rollBack();
            $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Hapus Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
        }
        DB::commit();
    }   

    private function initializedProperties(){
        $this->destinationId=null;
        $this->name=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
