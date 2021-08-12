<?php

namespace App\Http\Livewire\Master\Department;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
class Update extends Component
{
    public $departmentId;
    public $code;
    public $name;
    public $status;
    protected $listeners=[
        'updateDepartment'=>'showModal'
    ];

    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'max' => ':attribute maksimal :max karakter!',
        'unique' => 'kode/nama departemen ini sudah ada!',
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
        return view('livewire.master.department.update');
    }

    public function showModal(Department $department){
        $this->departmentId=$department->id;
        $this->code=$department->code;
        $this->name=$department->name;
        $this->status=$department->active;
        $this->emit('showModal','editModal');
    }

   public function update(){
        $this->validate();
        DB::beginTransaction();
        try{
            $departments = Department::whereId($this->departmentId)->first();
            $departments->code = $this->code;
            $departments->name = $this->name;
            $departments->active = $this->status;
            $departments->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Ubah Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('closeModal','editModal');
            $this->emit('reloadDepartments');
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
            'code' => 'required|min:2|max:5|unique:departments,code,'.$this->departmentId,
            'name' => 'required|min:4|max:40|unique:departments,name,'.$this->departmentId,
        ];
    }

    private function initializedProperties(){
        $this->code=null;
        $this->name=null;
        $this->status=null;
    }
}
