<?php

namespace App\Http\Livewire\User\Employee;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class Update extends Component
{
    public $employeeId;
    public $nrp;
    public $name;
    public $dateBirth;
    protected $listeners=[
        'resetPasswordEmployee'=>'showModal'
    ];


    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        //dd(date('dmy', strtotime($birtdateConvert)));
        return view('livewire.user.employee.update');
    }

    public function showModal(User $employees){
        $this->employeeId=$employees->id;
        $this->nrp=$employees->nrp;
        $this->name=$employees->name;
        $this->dateBirth=date('dmy',strtotime($employees->date_of_birth));
        $this->emit('showModal','editModal');
    }

    public function resetPassword(){
        DB::beginTransaction();
        try{
            $employees = User::whereId($this->employeeId)->first();
            $employees->password=Hash::make($this->dateBirth);
            $employees->save();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Reset Password',
                'message'=>'Berhasil reset password!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','editModal');
            $this->emit('reloadUserEmployees');
            $this->initializedProperties();
           
        }catch(\Throwable $th){
            DB::rollBack();
            $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Reset Password',
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
