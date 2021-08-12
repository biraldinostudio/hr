<?php

namespace App\Http\Livewire;

use App\Models\Assignment;
use Livewire\Component;
use\App\Models\User;
use\App\Models\DayOf;
use\App\Models\Permission;
use Auth;
use DB;
use DateTime;
class Home extends Component
{
    public function render()
    {
		         $qry='1';
        $siteCheck=Auth::user()->site_id;
        $departmentCheck=Auth::user()->position->department->id;        
        $dayOfs = DayOf::select(\DB::raw("COUNT(*) as count"),'c.code as department' )
            ->join('users as a','a.id','=','day_ofs.user_id')
            ->join('positions as b','b.id','=','a.position_id')
            ->join('departments as c','c.id','=','b.department_id')
            ->where('day_ofs.active','1')
            ->whereYear('day_ofs.start', date('Y'))
            //->where('day_ofs.site_id',Auth::user()->site->id)
            ->groupBy('department')
            ->orderBy('department')
            ->get();
         $dataDayOfs = [];
         foreach($dayOfs as $item) {
            $dataDayOfs['label'][] = $item->department;
            $dataDayOfs['data'][] = (int) $item->count;
          }
        $permissions = Permission::select(\DB::raw("COUNT(*) as count"),'c.code as department' )
        ->join('users as a','a.id','=','permissions.user_id')
        ->join('positions as b','b.id','=','a.position_id')
        ->join('departments as c','c.id','=','b.department_id')
        ->where('permissions.active','1')
        ->whereYear('permissions.start_date', date('Y'))
        //->where('permissions.site_id',Auth::user()->site->id)
        ->groupBy('department')
        ->orderBy('department')
        ->get();
        $dataPermissions = [];
        foreach($permissions as $item) {
            $dataPermissions['label'][] = $item->department;
            $dataPermissions['data'][] = (int) $item->count;
        }

        $assignments = Assignment::select(\DB::raw("COUNT(*) as count"),'c.code as department' )
        ->join('users as a','a.id','=','assignments.user_id')
        ->join('positions as b','b.id','=','a.position_id')
        ->join('departments as c','c.id','=','b.department_id')
        ->where('assignments.active','1')
        ->whereYear('assignments.start_date', date('Y'))
       // ->where('assignments.site_id',Auth::user()->site->id)
        ->groupBy('department')
        ->orderBy('department')
        ->get();
        $dataAssignments= [];
        foreach($assignments as $item) {
            $dataAssignments['label'][] = $item->department;
            $dataAssignments['data'][] = (int) $item->count;
        }
        $countTranss = DB::table('view_trans_site_join_dates')
            ->selectRaw('DATE_FORMAT(startDate,"%Y") as year,DATE_FORMAT(startDate,"%m") as month
            ,SUM(employDayOf) as sumDayOf,SUM(employAssign) as sumAssign,SUM(employPerm) as sumPerm'
            )
            ->groupBy('year','month')
            ->orderBy(DB::raw("DATE_FORMAT(startDate, '%Y'),'ASC'"))
            ->orderBy(DB::raw("DATE_FORMAT(startDate, '%m'),'ASC'"))
            ->get();
   
            $dataCountTransDayOfs= [];
            $dataCountTransPerms= [];
            $dataCountTransAssigns= [];
            $labelMonths=[];
            foreach($countTranss as $item) {
                $monthNum  = $item->month;
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('M');
                $labelMonths['labelMonth'][] = $monthName;
                $dataCountTransDayOfs['dataCountDayOf'][] = (int) $item->sumDayOf;
                $dataCountTransPerms['dataCountPerm'][] = (int) $item->sumPerm;
                $dataCountTransAssigns['dataCountAssign'][] = (int) $item->sumAssign;
            }
            return view('livewire.home',compact('countTranss','dataDayOfs','dataPermissions','dataAssignments','labelMonths','dataCountTransDayOfs','dataCountTransPerms','dataCountTransAssigns'))->extends('layouts.app')->section('content');
        }
}
