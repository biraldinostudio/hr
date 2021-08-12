<?php

namespace App\Http\Livewire\Master\Department;
use Livewire\Component;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    public $code;
    public $name;
    protected $rules = [
        'code' => 'required|min:2|max:5|unique:departments',
        'name' => 'required|min:4|max:40|unique:departments',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'unique' => 'Code / Nama departemen ini sudah ada!',
    ];

    protected $validationAttributes = [
        'code' => 'Kode departemen',
        'name' => 'Nama departemen'
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
        return view('livewire.master.department.create');
    }
    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $departments = new Department;
            $departments->code = $this->code;
            $departments->name = $this->name;
            $departments->active = '1';
            $departments->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->emit('closeModal','createModal');
            $this->emit('reloadDepartments');
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
    private function initializedProperties(){
        $this->code=null;
        $this->name=null;
    }
}
