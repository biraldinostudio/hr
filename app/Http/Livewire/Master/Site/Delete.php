<?php

namespace App\Http\Livewire\Master\Site;

use Livewire\Component;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $siteId;
    public $name;
    protected $listeners=[
        'deleteSite'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.master.site.delete');
    }

    public function showModal(Site $site){
        $this->siteId=$site->id;
        $this->name=$site->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            Site::whereId($this->siteId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadSites');
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
        $this->siteId=null;
        $this->name=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
