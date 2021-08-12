<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Models\DayOf;
use\App\Models\Assignment;
use\App\Models\Permission;
use Auth;
class HomeController extends Controller
{   
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
         $qry='1';
        $siteCheck=Auth::user()->site_id;
        $departmentCheck=Auth::user()->position->department->id;
                /*$countDayOfs=DayOf::SDayOfWhere($qry,$siteCheck,$departmentCheck)->where('approv','0')->count();
                $countPermissions=Permission::SPermissionWhere($qry,$siteCheck,$departmentCheck)->where('approv','0')->count();
                $countAssignments=Assignment::SAssignmentWhere($qry,$siteCheck,$departmentCheck)->where('approv','0')->count();
                'day_ofs.id','day_ofs.users_id','dasy_ofs.site_id','a.position_id','d.department_id','day_ofs.approv','day_ofs.active'
                */
                $countDayOfs=DayOf::query()->select('day_ofs.id','day_ofs.approv')                
                ->join('users as a', 'a.id', '=', 'day_ofs.user_id')
                ->join('sites as b', 'day_ofs.site_id', '=', 'b.id')
                ->join('positions as c', 'a.position_id', '=', 'c.id')
                ->join('departments as d', 'c.department_id', '=', 'd.id')
                 ->SDayOfWhere($qry,$siteCheck,$departmentCheck)->where('day_ofs.approv','0')->count();

                 $countPermissions=Permission::query()->select('permissions.id','permissions.approv')                
                 ->join('users as a', 'a.id', '=', 'permissions.user_id')
                 ->join('sites as b', 'permissions.site_id', '=', 'b.id')
                 ->join('positions as c', 'a.position_id', '=', 'c.id')
                 ->join('departments as d', 'c.department_id', '=', 'd.id')
                 ->SPermissionWhere($qry,$siteCheck,$departmentCheck)
                 ->where('permissions.approv','0')->count();

                 $countAssignments=Assignment::query()->select('assignments.id','assignments.approv')                
                     ->join('users as a', 'a.id', '=', 'assignments.user_id')
                     ->join('sites as b', 'assignments.site_id', '=', 'b.id')
                     ->join('positions as c', 'a.position_id', '=', 'c.id')
                     ->join('departments as d', 'c.department_id', '=', 'd.id')
                     ->SAssignmentWhere($qry,$siteCheck,$departmentCheck)
                     ->where('assignments.approv','0')->count();
            return view('home',compact('countDayOfs','countPermissions','countAssignments'));
        //}
        
    }
}
