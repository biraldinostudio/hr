<?php

namespace App\Http\Livewire\Amenities\PermissionCategory;

use App\Models\PermissionCategory;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    public $name;
    public $day;
    public $official;
    public $type;

    protected $listeners = [
        'selectType'=>'getSelectedType',
    ];

    protected $rules = [
        'type' => 'required',
        'name' => 'required|min:5|max:100|unique:permission_categories,name',    
        //'day' => 'required|numeric|digits_between:1,2|not_in:0',
        'day' => 'required|numeric|digits_between:0,2',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'numeric'=>':attribute format harus angka',
        'digits_between'=>':attribute 0 s/d 2 karakter',
        'not_in'=>':attribute tidak boleh angka 0',
        'unique'=>':attribute sudah ada',
    ];

    protected $validationAttributes = [
        'name' => 'Deskripsi izin',
        'day' => 'Jml Hari izin',
        'type' => 'Jenis izin',
    ];

    public function mount(){

        
        $this->initializedProperties();
    }
    
    public function updated($property, $value){
        if(trim($value)){
            $this->validateOnly($property);
        }else{
            $this->resetErrorBag($property);
        }
    }

    public function render()
    {
        if($this->type=='Official'){
            $this->official='1';
            $this->day= $this->day;
        }else{
            $this->official='0';
            $this->day='0';
        }
        
        return view('livewire.amenities.permission-category.create');
    }

    public function store(){
       // dd($this->official);
        $this->validate();   
        DB::beginTransaction();
        try{
            $permissionCategories = new PermissionCategory();
            $permissionCategories->name = $this->name;
            $permissionCategories->day = $this->day;
            $permissionCategories->official = $this->official;
            $permissionCategories->type = $this->type;                      
            $permissionCategories->active = '1';
            $permissionCategories->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','createModalPermissionCategory');
            $this->emit('reloadPermissionCategories');
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
        $this->permissionCategoryId=null;
        $this->name=null;
        $this->day=null;
        $this->official=null;
        $this->type=null;
    }

    public function getSelectedType($value) {
        $this->type=$value;
    }
}
