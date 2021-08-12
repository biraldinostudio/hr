<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', \App\Http\Livewire\Home::class)->name('home')->middleware('auth');
Route::prefix('master')->group(function(){
    Route::get('site/', \App\Http\Livewire\Master\Site\Index::class)->name('site')->middleware('auth');
	Route::get('poh/', \App\Http\Livewire\Master\Poh\Index::class)->name('poh')->middleware('auth');
	Route::get('destination/', \App\Http\Livewire\Master\Destination\Index::class)->name('destination')->middleware('auth');    
    Route::get('department/', \App\Http\Livewire\Master\Department\Index::class)->name('department')->middleware('auth');
    Route::get('position/', \App\Http\Livewire\Master\Position\Index::class)->name('position')->middleware('auth');
    Route::get('employee/', \App\Http\Livewire\Master\Employee\Index::class)->name('employee')->middleware('auth');

    Route::get('employee/edit/{id}', \App\Http\Livewire\Master\Employee\Update::class)->name('employee.edit')->middleware('auth');

    Route::get('departments/{code}/positions.json', function($code){	
        return \App\Models\Position::select('id','department_id','name')->where('active','1')->where('department_id',$code)->get();
     });    
   
    Route::get('employee/edit/departments/{code}/positions.json', function($code){	
       return \App\Models\Position::select('id','department_id','name')->where('active','1')->where('department_id',$code)->get();
    });  
});

Route::prefix('amenities')->group(function(){
    Route::get('poh-day-of/', \App\Http\Livewire\Amenities\PohDayOf\Index::class)->name('poh-day-of')->middleware('auth');
    Route::get('poh-annual-leave/', \App\Http\Livewire\Amenities\PohAnnualLeave\Index::class)->name('poh-annual-leave')->middleware('auth');
    Route::get('poh-annual-leave/edit/{id}', \App\Http\Livewire\Amenities\PohAnnualLeave\Update::class)->name('poh-annual-leave.edit')->middleware('auth');
    Route::get('poh-big-leave/', \App\Http\Livewire\Amenities\PohBigLeave\Index::class)->name('poh-big-leave')->middleware('auth');
    Route::get('poh-big-leave/edit/{id}', \App\Http\Livewire\Amenities\PohBigLeave\Update::class)->name('poh-big-leave.edit')->middleware('auth');
    /*
    Route::get('annual-leave/', \App\Http\Livewire\Amenities\AnnualLeave\Index::class)->name('annual-leave')->middleware('auth');
    Route::get('annual-leave/edit/{id}', \App\Http\Livewire\Amenities\AnnualLeave\Update::class)->name('annual-leave.edit')->middleware('auth');
    Route::get('big-leave/', \App\Http\Livewire\Amenities\BigLeave\Index::class)->name('big-leave')->middleware('auth');
    Route::get('big-leave/edit/{id}', \App\Http\Livewire\Amenities\BigLeave\Update::class)->name('big-leave.edit')->middleware('auth');
*/
Route::get('permission/category/', \App\Http\Livewire\Amenities\PermissionCategory\Index::class)->name('permission-category')->middleware('auth');
   Route::get('lump-sum/', \App\Http\Livewire\Amenities\LumpSum\Index::class)->name('lump-sum')->middleware('auth');
    Route::get('lump-sum/edit/{id}', \App\Http\Livewire\Amenities\LumpSum\Update::class)->name('lump-sum.edit')->middleware('auth');

    Route::get('day-of-period/', \App\Http\Livewire\Amenities\DayOfPeriod\Index::class)->name('day-of-period')->middleware('auth'); 
    Route::get('departments/{code}/positions.json', function($code){	
        return \App\Models\Position::select('id','department_id','name')->where('active','1')->where('department_id',$code)->get();
     });

     Route::get('lump-sum/edit/departments/{code}/positions.json', function($code){	
        return \App\Models\Position::select('id','department_id','name')->where('active','1')->where('department_id',$code)->get();
     });  
});

Route::prefix('transaction')->group(function(){
    Route::get('day-of/', \App\Http\Livewire\Transaction\DayOf\Index::class)->name('day-of')->middleware('auth');
    Route::get('my/day-of/', \App\Http\Livewire\Transaction\DayOf\Index::class)->name('my-day-of')->middleware('auth');
    Route::get('my/day-of/edit/{id}', \App\Http\Livewire\Transaction\DayOf\Update::class)->name('my-day-of.edit')->middleware('auth');
    Route::get('day-of/submission/{id}', [\App\Http\Livewire\Transaction\DayOf\Show::class,'submission'])->name('day-of.submission')->middleware('auth');
    Route::get('day-of/print/{id}',[ \App\Http\Livewire\Transaction\DayOf\Show::class,'print'])->name('day-of.print')->middleware('auth');

    Route::get('invoice/big-leave/', \App\Http\Livewire\Transaction\Invoice\BigLeave\Index::class)->name('invoice.big-leave')->middleware('auth');
    Route::get('invoice/big-leave/claim/', \App\Http\Livewire\Transaction\Invoice\BigLeave\Index::class)->name('invoice.big-leave-claim')->middleware('auth');

    Route::get('day-of/add/annual-leave/{id}', \App\Http\Livewire\Transaction\DayOf\AddAnnualLeave::class)->name('add-annual-leave')->middleware('auth');
    Route::get('day-of/add/big-leave/{id}', \App\Http\Livewire\Transaction\DayOf\AddBigLeave::class)->name('add-big-leave')->middleware('auth');

    Route::get('permission/', \App\Http\Livewire\Transaction\Permission\Index::class)->name('permission')->middleware('auth');
    Route::get('my/permission/', \App\Http\Livewire\Transaction\Permission\Index::class)->name('my-permission')->middleware('auth');  
    Route::get('permission/preview/{id}', [\App\Http\Livewire\Transaction\Permission\Show::class,'preview'])->name('permission.preview')->middleware('auth');
    Route::get('permission/print/{id}',[ \App\Http\Livewire\Transaction\Permission\Show::class,'print'])->name('permission.print')->middleware('auth'); 
    Route::get('permission/edit/{id}', \App\Http\Livewire\Transaction\Permission\Update::class)->name('permission.edit')->middleware('auth');
    Route::get('permission/detail/{id}',\App\Http\Livewire\Transaction\Permission\Detail::class)->name('permission.detail')->middleware('auth');

    Route::get('assignment/', \App\Http\Livewire\Transaction\Assignment\Index::class)->name('assignment')->middleware('auth');
    Route::get('my/assignment/', \App\Http\Livewire\Transaction\Assignment\Index::class)->name('my-assignment')->middleware('auth');
    Route::get('my/assignment/edit/{id}', \App\Http\Livewire\Transaction\Assignment\Update::class)->name('my-assignment.edit')->middleware('auth'); 
    Route::get('assignment/detail/{id}', \App\Http\Livewire\Transaction\Assignment\Detail::class)->name('assignment.detail')->middleware('auth');
    Route::get('assignment/preview/{id}', \App\Http\Livewire\Transaction\Assignment\Show::class)->name('assignment.preview')->middleware('auth');
    Route::get('assignment/print/{id}', \App\Http\Livewire\Transaction\Assignment\Show::class)->name('assignment.print')->middleware('auth'); 
   // Route::get('assignment/type/', \App\Http\Livewire\Transaction\Assignment\Index::class)->name('assignment-type')->middleware('auth'); 
    Route::get('assignment/preview/{id}', [\App\Http\Livewire\Transaction\Assignment\Show::class,'preview'])->name('assignment.preview')->middleware('auth');
    Route::get('assignment/print/{id}',[ \App\Http\Livewire\Transaction\Assignment\Show::class,'print'])->name('assignment.print')->middleware('auth'); 

});

Route::prefix('user')->group(function(){
    Route::get('my-account/', \App\Http\Livewire\User\MyAccount\Index::class)->name('my-account')->middleware('auth');
    Route::get('administrator/', \App\Http\Livewire\User\Administrator\Index::class)->name('administrator')->middleware('auth');
    Route::get('site-manager/', \App\Http\Livewire\User\SiteManager\Index::class)->name('site-manager')->middleware('auth');
    Route::get('department-head/', \App\Http\Livewire\User\DepartmentHead\Index::class)->name('department-head')->middleware('auth');
    Route::get('hr-head/', \App\Http\Livewire\User\HrHead\Index::class)->name('hr-head')->middleware('auth');
    Route::get('hr-admin/', \App\Http\Livewire\User\HrAdmin\Index::class)->name('hr-admin')->middleware('auth');


    Route::get('employee/reset/password', \App\Http\Livewire\User\Employee\Index::class)->name('employee.reset.password')->middleware('auth');

    Route::get('sites/{code}/employees.json', function($code){	
        return \App\Models\User::select('id','site_id','position_id','nrp','name')->where('staff','1')->whereIn('level',['employee','hrd_head','department_head'])->where('active','1')->where('site_id',$code)->get();
     });
});

Route::get('maintenance/', \App\Http\Livewire\Maintenance::class)->name('maintenance')->middleware('auth');

Route::prefix('report')->group(function(){
    //Route::get('day-of/export',\App\Http\Livewire\Transaction\DayOf\Index::class)->name('day-of-export')->middleware('auth');
    Route::get('export',\App\Http\Livewire\Export\Index::class)->name('report-export')->middleware('auth');    
});