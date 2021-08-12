<?php

namespace App\Http\Livewire\Amenities\PermissionCategory;

use Livewire\Component;
use App\Models\PermissionCategory;
use Illuminate\Support\Facades\DB;
class Delete extends Component
{
    public $permissionCategoryId;
    public $name;
    public $day;
    protected $listeners=[
        'deletePermissionCategory'=>'showModal'
    ];

    public function mount(){
        $this->initializedProperties();
    }
    public function render()
    {
        return view('livewire.amenities.permission-category.delete');
    }

    public function showModal(PermissionCategory $permissionCategories){
        $this->permissionCategoryId=$permissionCategories->id;
        $this->name=$permissionCategories->name;
        $this->day=$permissionCategories->day;
        $this->emit('showModal','deleteModalPermissionCategory');
    }

    public function delete(){
        DB::beginTransaction();
        try{
            PermissionCategory::whereId($this->permissionCategoryId)->delete();
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Hapus Data',
                'message'=>'Berhasil menghapus data!'
            ]);
            $this->emit('closeModal','deleteModalPermissionCategory');
            $this->emit('reloadPermissionCategories');
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
        $this->permissionCategoryId=null;
        $this->name=null;
        $this->day=null;
    }

    public function cancel(){
        $this->resetErrorBag();
        $this->initializedProperties();
    }
}
