<?php

namespace App\Http\Livewire\Master\Position;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Position;
use App\Models\Department;
class Update extends Component
{
    public $positionId;
    public $department='';
    public $name;
    public $status;
    protected $listeners=[
        'updatePosition'=>'showModal',
        "selectDepartment" => 'getSelectedDepartment'
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
        $departments=Department::select('id','name')->whereActive('1')->get();
        return view('livewire.master.position.update',compact('departments'));
    }

    public function showModal(Position $position){
        $this->positionId=$position->id;
        $this->department=$position->department->id;
        $this->name=$position->name;
        $this->status=$position->active;
        $this->emit('showModal','editModal');
    }

   public function update(){
        $this->validate();
        DB::beginTransaction();
        try{
            $positions = Position::whereId($this->positionId)->first();
            $positions->department_id = $this->department;
            $positions->name = $this->name;
            $positions->active = $this->status;
            $positions->save();
            $this->emit('refreshDropdown');
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Ubah Data',
                'message'=>'Berhasil mengubah data!'
            ]);
            $this->emit('closeModal','editModal');
            $this->emit('reloadPositions');
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
            'department' => 'required',
            'name' => 'required|min:4|max:40|unique:positions,name,'.$this->positionId,
            'status'=>'required',
        ];
    }

    private function initializedProperties(){
        $this->department=null;
        $this->name=null;
        $this->status=null;
    }

    public function getSelectedDepartment( $value) {
        $this->department = $value;
    }
}
