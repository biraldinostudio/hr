<?php

namespace App\Http\Livewire\Master\Position;

use Livewire\Component;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $positionId;
    public $name;
    protected $listeners=[
        'deletePosition'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.master.position.delete');
    }

    public function showModal(Position $position){
        $this->positionId=$position->id;
        $this->name=$position->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            Position::whereId($this->positionId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadPositions');
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
        $this->positionId=null;
        $this->name=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
