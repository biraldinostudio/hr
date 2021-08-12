<?php

namespace App\Http\Livewire\User\MyAccount;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;
class Show extends Component
{
    public $passwordOld;
    public $passwordNew;
    public $passwordConfirm;

    protected $listeners=[
        'reloadMyAccounts'=>'$refresh'
    ];
    protected $rules = [
        'passwordOld' => 'required',			
        'passwordNew' => 'required|min:6',
        'passwordConfirm' => 'required|same:passwordNew',
    ];
    protected $messages = [
        'required' => ':attribute wajib diisi!',
        'min' => ':attribute minimal :min karakter!',
        'same' => ':attribute harus sama dengan password baru!',
    ];

    protected $validationAttributes = [
        'passwordOld' => 'Kata sandi lama',
        'passwordNew' => 'Kata sandi baru',
        'passwordConfirm' => 'Konfirmasi kata sandi',
    ];

    public function mount(){
        $this->initializedProperties();
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }  
    
    public function render()
    {
        $myAccounts=User::where('id',Auth::user()->id)->first();
        return view('livewire.user.my-account.show',compact('myAccounts'));
    }

    public function updatePassword(){
        $this->validate();
	
        DB::beginTransaction();
        try{

            
		    $users = User::find(Auth::user()->id);
		    if(Hash::check($this->passwordOld,$users['password'])&& $this->passwordNew==$this->passwordConfirm){
			    $users->password=Hash::make(trim($this->passwordNew));
			    $users->save();
                $this->emit('flashMessage',[
                    'type'=>'success',
                    'title'=>'Ubah Data',
                    'message'=>'Berhasil menambahkan data!'
                ]);
                $this->initializedProperties();
                $this->emit('reloadMyAccounts');
            }
            else{
                $this->emit('flashMessage',[
                    'type'=>'error',
                    'title'=>'Ubah Data',
                    'message'=>'Error: Password lama salah!'
                ]);
            }
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

    private function initializedProperties(){
        $this->passwordOld=null;
        $this->passwordNew=null;
        $this->passwordConfirm=null;
    }
}
