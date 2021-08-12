<?php

namespace App\Http\Livewire\Amenities\LumpSum;

use Livewire\Component;
use App\Models\Lumpsum;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $lumpsumId;
    public $position;
    public $site;
    protected $listeners=[
        'deleteLumpSum'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.amenities.lump-sum.delete');
    }

    public function showModal(Lumpsum $lumpsum){
        $this->lumpsumId=$lumpsum->id;
        $this->site=$lumpsum->site->name;
        $this->poh=$lumpsum->position->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            Lumpsum::whereId($this->lumpsumId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadLumpSums');
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
        $this->lumpsumId=null;
        $this->site=null;
        $this->position=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
