<?php

namespace App\Http\Livewire\Amenities\PohDayOf;
use Livewire\Component;
use App\Models\PohDayOf;
use App\Models\Site;
use App\Models\Poh;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    public $site;
    public $poh;
    public $dayof;
    public $travel;
    public $travel_ticket;
    public $lumpsum;
    protected $rules = [
        'site'=> 'required',
        'poh' => 'required',
        'dayof' => 'required|numeric|digits_between:1,2|not_in:0',
        'travel' => 'required|numeric|digits_between:0,2',
        'travel_ticket' => 'required|numeric|digits_between:0,2',
        'travel_ticket' => 'required|numeric|digits_between:0,2',
        'lumpsum' => 'required',
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
        'site' => 'Nama site',
        'poh' => 'Nama POH',
        'dayof' => 'Hari cuti',
        'travel'=>'Hari travel (PP)',
        'travel_ticket'=>'Hari ticket (PP)',
        'lumpsum'=>'Fasilitas lumpsum',
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

    /*public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }*/


    public function render(){
        $sites=Site::select('id','name')->where('active','1')->get();
        $pohs=Poh::select('id','name')->where('active','1')->get();
        return view('livewire.amenities.poh-day-of.create',compact('sites','pohs'));
    }
    public function store(){
       // dd($this->province);
        $this->validate();
        DB::beginTransaction();
        try{
            $pohdayofs = new PohDayOf();
            $pohdayofs->site_id = $this->site;
            $pohdayofs->poh_id = $this->poh;
            $pohdayofs->day_of = $this->dayof;
            $pohdayofs->travel_day = $this->travel;
            $pohdayofs->travel_day_ticket = $this->travel_ticket;
            $pohdayofs->lumpsum_facilities = $this->lumpsum;
            $pohdayofs->active = '1';
            $pohdayofs->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->emit('closeModal','createModal');
            $this->emit('reloadPohDayOfs');
            $this->initializedProperties();
        }catch(\Throwable $th){
            DB::rollBack();
            $errorCode = $th->errorInfo[1];
            if($errorCode == '1062'){
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Create Data',
                    'message'=>'Data ini sudah ada, silahkan masukan data yang lain!'
                ]);
            }else{
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Create Data',
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
    private function initializedProperties(){
        $this->site=null;
        $this->poh=null;
        $this->dayof=null;
        $this->travel=null;
        $this->travel_ticket=null;
        $this->lumpsum=null;
    }
}