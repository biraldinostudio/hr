<?php

namespace App\Http\Livewire\User\Employee;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class UpdateAll extends Component
{
    public $countEmployees;
    protected $listeners=[
        'resetPasswordEmployee'=>'showModal'
    ];


    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.user.employee.update-all');
    }

    public function showModal(){
        $this->countEmployees=User::where('active')->where('level','employee')->where('employee','1')->count();
        $this->employees=User::where('active')->where('level','employee')->where('employee','1')->get();
        $this->emit('showModal','updateAllModal');
    }

    public function resetPasswordAll(){
        DB::beginTransaction();
        try{
            $employees=User::where('id','!=',1)->where('active','1')->where('level','employee')->where('date_of_birth','!=',null)->get();
            foreach($employees as $row){
                $employeeSaves = User::where('id',$row['id'])->where('id','!=',1)->where('active','1')->where('level','employee')->where('date_of_birth','!=',null)->first(); 
                $employeeSaves->password = Hash::make(date('dmy',strtotime($row['date_of_birth']))); 
                $employeeSaves->save(); 
            }
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Reset Password',
                'message'=>'Berhasil reset password!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','updateAllModal');
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
        $this->countEmployees=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
        $this->emit('closeModal','updateAllModal');
    }
}
