<?php

namespace App\Http\Livewire\Amenities\PermissionCategory;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\PermissionCategory;
class Update extends Component
{
    public $permissionCategoryId;
    public $name;
    public $day;
    public $official;
    public $type;
    public $status;
    protected $listeners=[
        'updatePermissionCategory'=>'showModal',
        'selectType'=>'getSelectedType'
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'numeric'=>':attribute format harus angka',
        'digits_between'=>':attribute 1 s/d 2 karakter',
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

    //Real time validate
    public function updated($property, $value){
            if(trim($value)){
                $this->validateOnly($property);
            }else{
                $this->resetErrorBag($property);
            }
        }

        public function showModal(PermissionCategory $permissionCategories){
            $this->permissionCategoryId=$permissionCategories->id;
            $this->name=$permissionCategories->name;
            $this->day=$permissionCategories->day;
            $this->official=$permissionCategories->official;
            $this->type=$permissionCategories->type;
            $this->status=$permissionCategories->active;
            $this->emit('showModal','editModalPermissionCategory');
        }

    public function render(){    
        if($this->day==0){
            $this->official='0';
        }else{
            $this->official='1';
        } 
        return view('livewire.amenities.permission-category.update');
    }



   public function update(){
    if($this->type=='Official'){
        $this->official='1';
        $this->day= $this->day;
    }else{
        $this->official='0';
        $this->day='0';
    }
        $this->validate();
        DB::beginTransaction();
        try{
            $permissionCategories = PermissionCategory::whereId($this->permissionCategoryId)->first();
            $permissionCategories->name = $this->name;
            $permissionCategories->day=$this->day;
            $permissionCategories->official = $this->official;  
            $permissionCategories->type = $this->type; 
            $permissionCategories->active = $this->status;
            $permissionCategories->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Ubah Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('closeModal','editModalPermissionCategory');
            $this->emit('reloadPermissionCategories');
            $this->initializedProperties();
           
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

    public function rules (){
        return[
            'type'=>'required',
            'name' => 'required|min:5|max:100|unique:permission_categories,name,'.$this->permissionCategoryId,    
            //'day' => 'required|numeric|digits_between:1,2|not_in:0',
            'day' => 'required|numeric|digits_between:0,2',
        ];
    }

    private function initializedProperties(){
        $this->permissionCategoryId=null;
        $this->name=null;
        $this->day=null;
        $this->official=null;
        $this->type=null;
        $this->status=null;
    }

    public function getSelectedType($value) {
        $this->type=$value;
    }
}
