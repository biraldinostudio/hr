<?php

namespace App\Http\Livewire\Master\Poh;

use Livewire\Component;
use App\Models\Poh;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $pohId;
    public $name;
    protected $listeners=[
        'deletePoh'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.master.poh.delete');
    }

    public function showModal(Poh $poh){
        $this->pohId=$poh->id;
        $this->name=$poh->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            Poh::whereId($this->pohId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadPohs');
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
        $this->pohId=null;
        $this->name=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
