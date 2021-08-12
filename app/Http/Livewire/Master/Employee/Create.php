<?php

namespace App\Http\Livewire\Master\Employee;
use Livewire\Component;
use App\Models\Site;
use App\Models\Poh;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class Create extends Component
{
    public $site='';
    public $poh='';
    public $department='';
    public $position='';
    public $nrp;
    public $ktp;
    public $name;
    public $birthplace;
    public $birthdate='';
    public $join='';
    public $religion;
    public $blood;
    public $address;
    public $phone;
    public $lumpsum;
    public $homeFacilities;
    public $staff;

    protected $rules = [
        'nrp' => 'required|numeric|min:7|unique:users',
        'name' => 'required|min:2|max:43',
        'department' => 'required',
        'position' => 'required',
        'join' => 'required|date_format:d/m/Y',
        'site' => 'required',
        'poh' => 'required',
        'ktp' => 'required|numeric|min:16',
        'religion' => 'required',
        'blood' => 'max:6|nullable',
        'address' => 'max:100|nullable',
        'phone' => 'min:5|max:13|nullable',
        'birthplace' => 'max:39|nullable',
        'birthdate' => 'required|date_format:d/m/Y|nullable',
        'lumpsum' => 'required|min:1|max:13|not_in:0|not_regex:/^Rp\s\d{1,3}(\.\d{3})*?$/',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'unique' => 'NRP ini sudah digunakan!',
        'date_format'=>':attribute format harus: d/m/Y',
        'numeric'=>':attribute format harus angka',
        'not_in'=>':attribute tidak boleh angka 0',
        'not_regex'=>':attribute karakter tidak valid',

    ];

    protected $validationAttributes = [
        'nrp' => 'NRP',
        'name' => 'Nama lengkap',
        'department' => 'Departemen',
        'position' => 'Jabatan',
        'join' => 'Tanggal bergabung',
        'site' => 'Site',
        'poh' => 'POH',
        'ktp' => 'KTP',
        'religion' => 'Agama',
        'blood' => 'Golongan darah',
        'address' => 'Alamat',
        'birthplace' => 'Tempat lahir',
        'birthdate' => 'Tanggal lahir',
        'lumpsum'=>'Rupiah lumpsum',
    ];

    public function mount(){
        $this->initializedProperties();
    }
    
    /*public function updated($property, $value){
        if(trim($value)){
            $this->validateOnly($property);
        }else{
            $this->resetErrorBag($property);
        }
    }*/

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function render(){
        $sites=Site::select('id','name')->where('active','1')->get();
        $pohs=Poh::select('id','name')->where('active','1')->get();
        $departments=Department::select('id','name')->where('active','1')->get();
        $positions=Position::select('id','name')->where('active','1')->get();
        return view('livewire.master.employee.create',compact('sites','pohs','departments','positions'))->extends('layouts.app')->section('content');
    }

    public function store(){
       $this->validate();
        if($this->staff==''){
            $this->staff='0';
        }
        if($this->homeFacilities==''){
            $this->homeFacilities='0';
        }    
        $joinConvert= str_replace('/', '-', $this->join);
        $birtdateConvert= str_replace('/', '-', $this->birthdate);
        if(currencyIDRToNumeric($this->lumpsum)>0){
            $lumpsumStatus='1';
        }else{
            $lumpsumStatus='0';
        }
        DB::beginTransaction();
        try{
            $employees = new User;
            $employees->site_id = $this->site;
            $employees->poh_id = $this->poh;
            $employees->position_id = $this->position;
            $employees->nrp = trim($this->nrp);
            $employees->ktp = trim($this->ktp);
            $employees->name = trim($this->name);
            $employees->password=Hash::make(date('dmy',strtotime(str_replace('/', '-', $this->birthdate))));
            $employees->place_of_birth = trim($this->birthplace);
            $employees->date_of_birth = date('Y-m-d', strtotime($birtdateConvert));
            $employees->join_date = date('Y-m-d', strtotime($joinConvert));
            $employees->religion = $this->religion;
            $employees->blood_type = $this->blood;
            $employees->address = trim($this->address);
            $employees->phone = trim($this->phone);
            $employees->staff = $this->staff;
            $employees->employee = '1';
            $employees->home_facilities = $this->homeFacilities;
            $employees->lumpsum = currencyIDRToNumeric($this->lumpsum);
            $employees->lumpsum_status= $lumpsumStatus;
            $employees->level = 'employee';
            $employees->active = '1';
            $employees->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            //$this->clearForm();
            $this->initializedProperties();
            $this->emit('closeModal','createModal');
            $this->emit('reloadEmployees');
        }catch(\Throwable $th){
            DB::rollBack();
          $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Create Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
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
        $this->department=null;
        $this->position=null;
        $this->nrp=null;
        $this->ktp=null;
        $this->name=null;
        $this->birthplace=null;
        $this->birthdate=null;
        $this->join=null;
        $this->religion=null;
        $this->blood=null;
        $this->address=null;
        $this->phone=null;
        $this->lumpsum=null;
        $this->homeFacilities=null;
        $this->staff=null;


    }

}