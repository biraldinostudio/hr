<?php

namespace App\Http\Livewire\Master\Department;

use Livewire\Component;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $departmentId;
    public $name;
    protected $listeners=[
        'deleteDepartment'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.master.department.delete');
    }

    public function showModal(Department $department){
        $this->departmentId=$department->id;
        $this->name=$department->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            Department::whereId($this->departmentId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadDepartments');
            $this->initializedProperties();
        }catch(\Throwable $th){
            DB::rollBack();
            $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Hapus Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
        }
        DB::commit();
    }   

    private function initializedProperties(){
        $this->departmentId=null;
        $this->name=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
