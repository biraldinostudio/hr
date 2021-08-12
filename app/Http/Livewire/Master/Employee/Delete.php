<?php

namespace App\Http\Livewire\Master\Employee;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $employeeId;
    public $name;
    protected $listeners=[
        'deleteEmployee'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.master.employee.delete');
    }

    public function showModal(User $employee){
        $this->employeeId=$employee->id;
        $this->name=$employee->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            User::whereId($this->employeeId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadEmployees');
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
        $this->employeeId=null;
        $this->name=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
