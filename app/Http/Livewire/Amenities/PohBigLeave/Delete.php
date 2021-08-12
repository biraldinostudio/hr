<?php

namespace App\Http\Livewire\Amenities\PohBigLeave;

use Livewire\Component;
use App\Models\PohBigLeave;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $pohBigLeaveId;
    public $poh;
    public $site;
    protected $listeners=[
        'deletePohBigLeave'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.amenities.poh-big-leave.delete');
    }

    public function showModal(PohBigLeave $pohBigLeaves){
        $this->pohBigLeaveId=$pohBigLeaves->id;
        $this->site=$pohBigLeaves->site->name;
        $this->poh=$pohBigLeaves->poh->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            BigLeave::whereId($this->pohBigLeaveId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadPohBigLeaves');
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
        $this->pohBigLeaveId=null;
        $this->site=null;
        $this->poh=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
