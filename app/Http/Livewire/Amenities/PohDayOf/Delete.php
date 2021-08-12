<?php

namespace App\Http\Livewire\Amenities\PohDayOf;

use Livewire\Component;
use App\Models\PohDayOf;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $pohdayofId;
    public $poh;
    public $site;
    protected $listeners=[
        'deletePohDayOf'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.amenities.poh-day-of.delete');
    }

    public function showModal(PohDayOf $pohdayof){
        $this->pohdayofId=$pohdayof->id;
        $this->site=$pohdayof->site->name;
        $this->poh=$pohdayof->poh->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            PohDayOf::whereId($this->pohdayofId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadPohDayOfs');
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
        $this->pohdayofId=null;
        $this->site=null;
        $this->poh=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
