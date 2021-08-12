<?php

namespace App\Http\Livewire\Master\Position;
use Livewire\Component;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
class Create extends Component
{
    //public $data;
    public $name;
    public $department='';
    public $type;

    protected $listeners = [
        "selectDepartment" => 'getSelectedDepartment'
    ];

    protected $rules = [
        'department' => 'required',
        'name' => 'required|min:4|max:40|unique:positions',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'unique' => 'Jabatan ini sudah ada!',
    ];

    protected $validationAttributes = [
        'department' => 'Departemen',
        'name' => 'Jabatan',
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
        $departments=Department::select('id','name')->whereActive('1')->get();
        return view('livewire.master.position.create',compact('departments'));
    }
    public function store(){
        $this->validate();
        DB::beginTransaction();
        try{
            $positions = new Position();
            $positions->department_id = $this->department;
            $positions->name = $this->name;
            $positions->active = '1';
            $positions->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Create Data',
                'message'=>'Berhasil menambahkan data!'
            ]);
            $this->emit('closeModal','createModal');
            $this->emit('reloadPositions');
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
        $this->department=null;
        $this->name=null;
    }

    public function getSelectedDepartment( $value) {
        $this->department = $value;
    }
}