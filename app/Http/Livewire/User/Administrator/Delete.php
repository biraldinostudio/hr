<?php

namespace App\Http\Livewire\User\Administrator;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $employeeId;
    public $employee;
    public $nrp;
    protected $listeners=[
        'deleteAdministrator'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.user.administrator.delete');
    }

    public function showModal(User $employee){
        $this->employeeId=$employee->id;
        $this->nrp=$employee->nrp;
        $this->employee=$employee->name;
        $this->emit('showModal','deleteModal');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            $employees = User::whereId($this->employeeId)->first();
            $employees->level='employee';
            $employees->save(); 
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Non Aktifkan Data',
                'message'=>'Berhasil menonaktifkan data!'
            ]);
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadAdministrators');
            $this->initializedProperties();
        }catch(\Throwable $th){
            DB::rollBack();
            $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Non Aktifkan Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
        }
        DB::commit();
    }   

    private function initializedProperties(){
        $this->employeeId=null;
        $this->nrp=null;
        $this->employee=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
