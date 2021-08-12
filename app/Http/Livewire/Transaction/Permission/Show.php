<?php

namespace App\Http\Livewire\Transaction\Permission;

use Livewire\Component;
use App\Models\Permission;
use App\Models\ApprovalRecord;
use App\Models\PermissionCategory;
use App\Models\PermissionDebt;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Auth;
class Show extends Component
{
    use WithPagination;
    public $sortBy='created_at';
    public $sortDirection = 'asc';
    public $foo;
    public $search = '';
    public $page = 1;
    public $perPagination = 10;
    public $status;

    public $number;
    public $employeeId;
    public $permissionId; 
    public $nrp;
    public $name;
    public $position;
    public $department;
    public $site;
    public $address;
    public $phone;
    public $startDate;
    public $endDate;
    public $inDate;
    public $sumDay;
    public $cutDayOf;
    public $description;

    public $permissionCategory;
    public $permissionCategoryOfficial;
    public $permissionCategoryType;
    public $permissionCategoryName;
    public $permissionCategoryDay;

    public $reason;

    public $approvMode = false;
    public $notApprovMode = false;

    protected $paginationTheme = 'bootstrap';
    protected $listeners=[
        'reloadPermissions'=>'$refresh'
    ];

    protected $queryString = [
        'foo',
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $validationAttributes = [
        'reason'=>'Alasan Tidak Setuju',
    ];

    public function mount(){
        $this->initializedProperties();
    }

    public function updatingSearch(){
        $this->resetPage();
        
    }

    public function updated($property, $value){
        if(trim($value)){
            $this->validateOnly($property);
        }else{
            $this->resetErrorBag($property);
        }
    }

    public function showModalApprov($id){
        $this->approvMode = true;
        $this->notApprovMode = false;
        $this->emit('closeModal','notApprovModal');
        $permissions = Permission::where('id',$id)->first();
        $this->permissionId=$permissions->id;
        $this->number=$permissions->number;
        $this->employeeId=$permissions->user->id;
        $this->permissionCategory=$permissions->permission_category_id;
        $this->nrp=$permissions->user->nrp;
        $this->name=$permissions->user->name;
        $this->position=$permissions->user->position->name;
        $this->department=$permissions->user->position->department->name;
        $this->site=$permissions->user->site->name;
        $this->address=$permissions->user->address;
        $this->phone=$permissions->user->phone;
        $this->startDate = date('d/m/Y',strtotime($permissions->start_date));
        $this->endDate = date('d/m/Y',strtotime($permissions->end_date));
        $this->inDate = date('d/m/Y',strtotime($permissions->in_date));
        $this->sumDay=$permissions->sum_day;
        $this->cutDayOf=$permissions->cut_day_of;
        $this->description=$permissions->description;

        $permissionCategories=PermissionCategory::where('id',$this->permissionCategory)->first();
        if($permissionCategories){
            $this->permissionCategoryOfficial=$permissionCategories->official;
            $this->permissionCategoryType=$permissionCategories->type;
            $this->permissionCategoryName=$permissionCategories->name;
            $this->permissionCategoryDay=$permissionCategories->day;
        }

    }

    public function showModalNotApprov($id){
        $this->notApprovMode = true;
        $this->approvMode = false;
        $this->emit('closeModal','approvModal');
        $permissions = Permission::where('id',$id)->first();
        $this->permissionId=$permissions->id;
        $this->number=$permissions->number;
        $this->employeeId=$permissions->user->id;
        $this->nrp=$permissions->user->nrp;
        $this->name=$permissions->user->name;
        $this->position=$permissions->user->position->name;
        $this->department=$permissions->user->position->department->name;
        $this->site=$permissions->user->site->name;
    }
    
    public function render()
    {
        $this->emit('resetSelect2');
        if($this->status==null){
            $qry="1";
        }
        else{
            $qry=$this->status;
        } 
        $siteCheck=Auth::user()->site_id;
        $departmentCheck=Auth::user()->position->department->id;
        $permissions=Permission::query()->select('permissions.id','permissions.user_id','permissions.site_id','permissions.start_date','permissions.end_date','permissions.in_date','permissions.sum_day','permissions.description','permissions.head_approv','permissions.sm_approv','permissions.hrd_approv','permissions.approv','permissions.active','permissions.created_at'
                ,'a.nrp','a.name','a.position_id','a.level as employeeLevel','c.name as position','c.department_id','d.name as department'
                )                
                ->join('users as a', 'a.id', '=', 'permissions.user_id')
                ->join('sites as b', 'permissions.site_id', '=', 'b.id')
                ->join('positions as c', 'a.position_id', '=', 'c.id')
                ->join('departments as d', 'c.department_id', '=', 'd.id')
                ->orWhere(function($query)  {
                    $query->where('a.name','like','%'.trim($this->search).'%')
                          ->orWhere('a.nrp','like','%'.trim($this->search).'%')
                          ->orWhere('b.name','like','%'.trim($this->search).'%')
                          ;
                })
                ->SPermissionWhere($qry,$siteCheck,$departmentCheck)
                ->orderBy($this->sortBy,$this->sortDirection)->paginate($this->perPagination);
        return view('livewire.transaction.permission.show',compact('permissions'));
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

    public function preview($id){
        $permissions=Permission::find($id);
        $permissionCategories=PermissionCategory::whereId($permissions->permission_category_id)->first();
        $approvalRecords=ApprovalRecord::select('a.head_approv','a.hrd_approv','a.sm_approv','c.level as level_approv','c.nrp','c.name as approver','c.hr_head','approval_records.level as level_order','approval_records.created_at')
            ->leftjoin('permissions as a', 'a.id', '=', 'approval_records.doc')
            ->join('users as b', 'b.id', '=', 'a.user_id')  
            ->leftjoin('users as c', 'c.id', '=', 'approval_records.user_id')        
            ->where('approval_records.doc',$permissions->id)->where('approval_records.type','izin')->get();           
          return view('livewire.transaction.permission.preview',
             [
                'permissions'=>$permissions,
                'approvalRecords'=>$approvalRecords,
                'permissionCategories'=>$permissionCategories
            ]);
    }

    public function print($id){
        $permissions=Permission::find($id);
        $permissionCategories=PermissionCategory::whereId($permissions->permission_category_id)->first();
        $approvalRecords=ApprovalRecord::select('a.head_approv','a.hrd_approv','a.sm_approv','c.level as level_approv','c.nrp','c.name as approver','c.hr_head','approval_records.level as level_order','approval_records.created_at')
            ->leftjoin('permissions as a', 'a.id', '=', 'approval_records.doc')
            ->join('users as b', 'b.id', '=', 'a.user_id')  
            ->leftjoin('users as c', 'c.id', '=', 'approval_records.user_id')        
            ->where('approval_records.doc',$permissions->id)->where('approval_records.type','izin')->get();           
          return view('livewire.transaction.permission.print',
             [
                'permissions'=>$permissions,
                'approvalRecords'=>$approvalRecords,
                'permissionCategories'=>$permissionCategories
            ]);
    }
    public function approvStore(){
        $permissionChecks=PermissionDebt::where('permission_id',$this->permissionId)->first();
        DB::beginTransaction();
        try{
            $getPermissions = Permission::whereId($this->permissionId)->first();
            if($getPermissions->user->level=='employee' or $getPermissions->user->level=='hrd_admin'){
                if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='0'){
                    $approvs = Permission::whereId($this->permissionId)->first();
                    $approvs->head_approv='1';
                    $approvs->save();
    
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->level='1';
                    $approvRecords->type='izin';
                    $approvRecords->active='1';
                    $approvRecords->save(); 
                }
    
                if(Auth::user()->hr_head=='1'){
                    $approvs = Permission::whereId($this->permissionId)->first();
                    $approvs->hrd_approv='1';
                    $approvs->approv='1';
                    $approvs->save();
    
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->level='2';
                    $approvRecords->type='izin';
                    $approvRecords->active='1';
                    $approvRecords->save();

                    if($permissionChecks){
                        if($permissionChecks!=null){
                            $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                            $permissionDebts->approv = '1';
                            $permissionDebts->save(); 
                        }
                    }                   
                }
            }

            if($getPermissions->user->level=='department_head'){    
                if(Auth::user()->hr_head=='1'){
                    $approvs = Permission::whereId($this->permissionId)->first();
                    $approvs->hrd_approv='1';
                    $approvs->save();
    
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->level='1';
                    $approvRecords->type='izin';
                    $approvRecords->active='1';
                    $approvRecords->save();                 
                }

                if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                    $approvs = Permission::whereId($this->permissionId)->first();
                    $approvs->sm_approv='1';
                    $approvs->approv='1';
                    $approvs->save();
    
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->level='2';
                    $approvRecords->type='izin';
                    $approvRecords->active='1';
                    $approvRecords->save();

                    if($permissionChecks){
                        if($permissionChecks!=null){
                            $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                            $permissionDebts->approv = '1';
                            $permissionDebts->save(); 
                        }
                    }                   
                }
            }

            if($getPermissions->user->level=='site_manager'){
				if(Auth::user()->hr_head=='1'){
                    $approvs = Permission::whereId($this->permissionId)->first();
                    $approvs->hrd_approv='1';
                    $approvs->save();
    
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->level='1';
                    $approvRecords->type='izin';
                    $approvRecords->active='1';
                    $approvRecords->save();                 
                }

                if(Auth::user()->level=='site_manager' and Auth::user()->hr_head=='0'){
                    $approvs = Permission::whereId($this->permissionId)->first();
                    $approvs->sm_approv='1';
                    $approvs->approv='1';
                    $approvs->save();
    
                    $approvRecords = new ApprovalRecord();
                    $approvRecords->doc=$approvs->id;
                    $approvRecords->user_id=Auth::user()->id;
                    $approvRecords->level='2';
                    $approvRecords->type='izin';
                    $approvRecords->active='1';
                    $approvRecords->save();

                    if($permissionChecks){
                        if($permissionChecks!=null){
                            $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                            $permissionDebts->approv = '1';
                            $permissionDebts->save(); 
                        }
                    }                   
                }
            }
            
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Approv Data',
                'message'=>'Berhasil approv data!'
            ]);
            $this->approvMode = false;
            $this->emit('closeModal','approvModal');
            $this->emit('reloadPermissions');
            $this->initializedProperties();
        }catch(\Throwable $th){
            DB::rollBack();
            $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Approv Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
        }
        DB::commit();
    }
    public function notApprovStore(){
        $this->validate();
        $permissionChecks=PermissionDebt::where('permission_id',$this->permissionId)->first();
        DB::beginTransaction();
        try{
                $getPermissions = Permission::whereId($this->permissionId)->first();
                if($getPermissions->user->level=='employee' or $getPermissions->user->level=='hrd_admin'){
                    if(Auth::user()->level=='department_head' and Auth::user()->hr_head=='0'){
                        $approvs = Permission::whereId($this->permissionId)->first();
                        $approvs->head_approv='2';
                        $approvs->approv='2';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->reason=$this->reason;
                        $approvRecords->level='1';
                        $approvRecords->type='izin';
                        $approvRecords->active='1';
                        $approvRecords->save();
                        
                        if($permissionChecks){
                            if($permissionChecks!=null){
                                $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                                $permissionDebts->approv = '2';
                                $permissionDebts->save(); 
                            }
                        }
                    }
        
                    if(Auth::user()->hr_head=='1'){
                        $approvs = Permission::whereId($this->permissionId)->first();
                        $approvs->hrd_approv='2';
                        $approvs->approv='2';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->reason=$this->reason;
                        $approvRecords->level='2';
                        $approvRecords->type='izin';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($permissionChecks){
                            if($permissionChecks!=null){
                                $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                                $permissionDebts->approv = '2';
                                $permissionDebts->save(); 
                            }
                        }
                    }
                }

                if($getPermissions->user->level=='site_manager'){
                    if(Auth::user()->hr_head=='1'){
                        $approvs = Permission::whereId($this->permissionId)->first();
                        $approvs->hrd_approv='2';
                        $approvs->approv='2';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->reason=$this->reason;
                        $approvRecords->level='1';
                        $approvRecords->type='izin';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($permissionChecks){
                            if($permissionChecks!=null){
                                $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                                $permissionDebts->approv = '2';
                                $permissionDebts->save(); 
                            }
                        }
                    }

                    if(Auth::user()->level=='site_manager'){
                        $approvs = Permission::whereId($this->permissionId)->first();
                        $approvs->hrd_approv='2';
                        $approvs->approv='2';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->reason=$this->reason;
                        $approvRecords->level='2';
                        $approvRecords->type='izin';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($permissionChecks){
                            if($permissionChecks!=null){
                                $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                                $permissionDebts->approv = '2';
                                $permissionDebts->save(); 
                            }
                        }
                    }
                }

                if($getPermissions->user->level=='department_head'){
                    if(Auth::user()->hr_head=='1'){
                        $approvs = Permission::whereId($this->permissionId)->first();
                        $approvs->hrd_approv='2';
                        $approvs->approv='2';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->reason=$this->reason;
                        $approvRecords->level='1';
                        $approvRecords->type='izin';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($permissionChecks){
                            if($permissionChecks!=null){
                                $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                                $permissionDebts->approv = '2';
                                $permissionDebts->save(); 
                            }
                        }
                    }

                    if(Auth::user()->level=='site_manager'){
                        $approvs = Permission::whereId($this->permissionId)->first();
                        $approvs->hrd_approv='2';
                        $approvs->approv='2';
                        $approvs->save();
        
                        $approvRecords = new ApprovalRecord();
                        $approvRecords->doc=$approvs->id;
                        $approvRecords->user_id=Auth::user()->id;
                        $approvRecords->reason=$this->reason;
                        $approvRecords->level='2';
                        $approvRecords->type='izin';
                        $approvRecords->active='1';
                        $approvRecords->save();
    
                        if($permissionChecks){
                            if($permissionChecks!=null){
                                $permissionDebts=PermissionDebt::where('permission_id',$this->permissionId)->first();
                                $permissionDebts->approv = '2';
                                $permissionDebts->save(); 
                            }
                        }
                    }
                }
        
            $this->emit('flashMessage',[
                'type'=>'success',
                'title'=>'Approv Data',
                'message'=>'Berhasil approv data!'
            ]);
            $this->notApprovMode = false;
            $this->emit('closeModal','notApprovModal');
            $this->emit('reloadPermissions');
            $this->initializedProperties();          
        }catch(\Throwable $th){
            DB::rollBack();
            $this->emit('flashMessage',[
                'type'=>'error',
                'title'=>'Approv Data',
                'message'=>'Error:'.$th->getMessage()
            ]);
        }
        DB::commit();
    }
    public function initializedProperties(){
        $this->employeeId;
        $this->permissionId;
        $this->nrp;
        $this->name;
        $this->position;
        $this->department;
        $this->site;
        $this->address;
        $this->phone;
        $this->startDate;
        $this->endDate;
        $this->inDate;
        $this->sumDay;
        $this->cutDayOf;
        $this->description;

        $this->permissionCategory;
        $this->permissionCategoryOfficial;
        $this->permissionCategoryType;
        $this->permissionCategoryName;
        $this->permissionCategoryDay;

        $this->reason=null;
    }

    public function cancel()
    {
        $this->approvMode = false;
        $this->notApprovMode = false;
        $this->resetErrorBag();
        $this->initializedProperties();
        $this->emit('closeModal','approvModal');
        $this->emit('closeModal','notApprovModal');
    }

    public function rules (){
        return [
            'reason' => 'required|min:10|max:500',
        ];
    }

    public function messages(){
        return [
            'required' => ':attribute wajib diisi!',
            'min'=>':attribute minimal :min karakter',
            'max'=>':attribute maksimal :max karakter',
        ];
    }
}
