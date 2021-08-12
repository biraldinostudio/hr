<?php

namespace App\Http\Livewire\Amenities\PohDayOf;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\PohDayOf;
use App\Models\Site;
use App\Models\Poh;
class Update extends Component
{
    public $pohdayofId;
    public $site;
    public $poh;
    public $dayof;
    public $travel;
    public $travel_ticket;
    public $status;
    public $lumpsum;
    protected $listeners=[
        'updatePohDayOf'=>'showModal'
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'dayof.digits_between'=>':attribute 1 s/d 2 karakter',
        'digits_between'=>':attribute 0 s/d 2 karakter',
        'not_in'=>':attribute tidak boleh angka 0',
    ];

    protected $validationAttributes = [
        'site' => 'Nama Site',
        'poh' => 'Nama POH',
        'dayof' => 'Hari cuti',
        'travel' => 'Hari travel (PP)',
        'travel_ticket' => 'Hari ticket (PP)',
        'lumpsum'=>'Fasilitas lumpsum',
        'status' => 'Status'
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
        $sites=Site::select('id','name')->whereActive('1')->get();
        $pohs=Poh::select('id','name')->whereActive('1')->get();        
        return view('livewire.amenities.poh-day-of.update',compact('sites','pohs'));
    }

    public function showModal(PohDayOf $pohdayof){
        $this->pohdayofId=$pohdayof->id;
        $this->site=$pohdayof->site->id;
        $this->poh=$pohdayof->poh->id;
        $this->dayof=$pohdayof->day_of;
        $this->travel=$pohdayof->travel_day;
        $this->travel_ticket=$pohdayof->travel_day_ticket;
        $this->lumpsum=$pohdayof->lumpsum_facilities;
        $this->status=$pohdayof->active;
        $this->emit('showModal','editModal');
    }

   public function update(){
        $this->validate();
        DB::beginTransaction();
        try{
            $pohdayofs = PohDayOf::whereId($this->pohdayofId)->first();
            $pohdayofs->site_id = $this->site;
            $pohdayofs->poh_id = $this->poh;
            $pohdayofs->day_of=$this->dayof;
            $pohdayofs->travel_day=$this->travel;
            $pohdayofs->travel_day_ticket=$this->travel_ticket;
            $pohdayofs->lumpsum_facilities=$this->lumpsum;
            $pohdayofs->active = $this->status;
            $pohdayofs->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Ubah Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('closeModal','editModal');
            $this->emit('reloadPohDayOfs');
            $this->initializedProperties();
           
        }catch(\Throwable $th){
            DB::rollBack();
            $errorCode = $th->errorInfo[1];
            if($errorCode == '1062'){
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Update Data',
                    'message'=>'Data ini sudah ada, silahkan masukan data yang lain!'
                ]);
            }else{
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Update Data',
                    'message'=>'Error:'.$th->getMessage()
                ]);
            }
        }
        DB::commit();
    }
    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }

    public function rules (){
        return[
            'site' => 'required',
            'poh' => 'required',
            //'dayof' => 'required|max:2',
            //'travel' => 'required|max:1',
            'dayof' => 'required|numeric|digits_between:1,2|not_in:0',
            'travel' => 'required|numeric|digits_between:0,2',
            'travel_ticket' => 'required|numeric|digits_between:0,2',
            'lumpsum'=>'required',
            'status' => 'required',
        ];
    }

    private function initializedProperties(){
        $this->site=null;
        $this->poh=null;
        $this->dayof=null;
        $this->travel=null;
        $this->travel_ticket=null;
        $this->lumpsum=null;
        $this->status=null;
    }
}
