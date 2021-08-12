<?php

namespace App\Http\Livewire\Amenities\PohAnnualLeave;

use Livewire\Component;
use App\Models\PohAnnualLeave;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $annualleaveId;
    public $poh;
    public $site;
    protected $listeners=[
        'deletePohAnnualLeave'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.amenities.poh-annual-leave.delete');
    }

    public function showModal(PohAnnualLeave $PohAnnualLeaves){
        $this->pohAnnualLeaveId=$PohAnnualLeaves->id;
        $this->site=$PohAnnualLeaves->site->name;
        $this->poh=$PohAnnualLeaves->poh->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            PohAnnualLeave::whereId($this->pohAnnualLeaveId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadPohAnnualLeaves');
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
        $this->pohAnnualLeaveId=null;
        $this->site=null;
        $this->poh=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
