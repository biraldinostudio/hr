<?php

namespace App\Http\Livewire\Master\Site;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Site;
class Update extends Component
{
    public $siteId;
    public $code;
    public $name;
    public $status;
    protected $listeners=[
        'updateSite'=>'showModal'
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'unique' => 'Kode / nama site ini sudah ada!',
    ];

    protected $validationAttributes = [
        'code' => 'Kode site',
        'name' => 'Nama site'
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
        return view('livewire.master.site.update');
    }

    public function showModal(Site $site){
        $this->siteId=$site->id;
        $this->code=$site->code;
        $this->name=$site->name;
        $this->status=$site->active;
        $this->emit('showModal','editModal');
    }

   public function update(){
        $this->validate();
        DB::beginTransaction();
        try{
            $sites = Site::whereId($this->siteId)->first();
            $sites->code = $this->code;
            $sites->name = $this->name;
            $sites->active = $this->status;
            $sites->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Ubah Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('closeModal','editModal');
            $this->emit('reloadSites');
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
            'code' => 'required|min:2|max:5|unique:sites,code,'.$this->siteId,
            'name' => 'required|min:4|max:40|unique:sites,name,'.$this->siteId,
        ];
    }

    private function initializedProperties(){
        $this->code=null;
        $this->name=null;
        $this->status=null;
    }
}
