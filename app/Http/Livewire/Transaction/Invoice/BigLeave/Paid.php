<?php

namespace App\Http\Livewire\Transaction\Invoice\BigLeave;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\BigLeaveClaim;
class Paid extends Component
{
    public $bigLeaveClaimId;
    public $employeeId;
    public $nrp;
    public $name;
    protected $listeners=[
        'updatePaid'=>'showModal'
    ];


    public function mount(){
        $this->initializedProperties();
    }

    public function showModal(BigLeaveClaim $bigLeaveClaims){
        $this->bigLeaveClaimId=$bigLeaveClaims->id;
        $this->employeeId=$bigLeaveClaims->user->id;
        $this->nrp=$bigLeaveClaims->user->nrp;
        $this->name=$bigLeaveClaims->user->name;
        $this->emit('showModal','editModal');
    }

    public function render()
    {
        return view('livewire.transaction.invoice.big-leave.paid');
    }

    public function paidOff(){
        DB::beginTransaction();
        try{

            $claimStatuss = BigLeaveClaim::whereId($this->bigLeaveClaimId)->first();
            $claimStatuss->paid = '1';
            $claimStatuss->save();

            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Pelunasan Pembayaran',
                'message'=>'Berhasil simpan data!'
            ]);
            $this->initializedProperties();
            $this->emit('closeModal','editModal');
            $this->emit('reloadBigLeaveClaim');
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
        $this->bigLeaveClaimId=null;
        $this->employeeId=null;
        $this->nrp=null;
        $this->name=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
