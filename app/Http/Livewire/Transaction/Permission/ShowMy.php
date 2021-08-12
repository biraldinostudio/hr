<?php

namespace App\Http\Livewire\Transaction\Permission;

use Livewire\Component;
use App\Models\Permission;
use App\Models\PermissionDebt;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Auth;
class ShowMy extends Component
{
    use WithPagination;
    public $sortBy='created_at';
    public $sortDirection = 'asc';
    public $foo;
    public $search = '';
    public $page = 1;
    public $perPagination = 10;
    public $status;


    public $permissionId;
    public $number;

    public $deleteMode = false;

    protected $paginationTheme = 'bootstrap';
    protected $listeners=[
        'reloadPermissions'=>'$refresh',
    ];

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function mount(){
        $this->initializedProperties();
    }

    public function updatingSearch(){
        $this->resetPage();
        
    }

    public function showModalDelete($id){
        $this->deleteMode = true;
        $permissions = Permission::where('id',$id)->first();
        $this->permissionId=$permissions->id;
        $this->number=$permissions->number;
    }    

    public function render(){
        $this->emit('resetSelect2');
        if($this->status==null){
            $qry="1";
        }
        else{
            $qry=$this->status;
        }
        $permissions=Permission::query()->select('id','user_id','site_id','start_date','end_date','in_date','sum_day','description','head_approv','sm_approv','hrd_approv','approv','active','created_at')
            ->where('site_id','like','%'.trim($this->search).'%')
            ->where('active',$qry)
            ->where('user_id',Auth::user()->id)
            ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
         return view('livewire.transaction.permission.show-my',compact('permissions'));   
    }

    public function sortBy($field){
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort(){
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }

    public function submission($id){
        $dayOfs=DayOf::find($id);
        return view('livewire.transaction.permission.show-my',compact('dayOfs'));
    }

    public function deletePermission(){
        DB::beginTransaction();
        try{
            PermissionDebt::where('permission_id',$this->permissionId)->delete();
            Permission::whereId($this->permissionId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->deleteMode = false;
            $this->emit('closeModal','deleteModal');
            $this->emit('reloadPermissions');
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

    public function initializedProperties(){
        $this->permissionId=null;;
        $this->number=null;
    }

    public function cancel()
    {
        $this->deleteMode = false;
        $this->resetErrorBag();
        $this->initializedProperties();
        $this->emit('closeModal','deleteModal');
    }
}
 