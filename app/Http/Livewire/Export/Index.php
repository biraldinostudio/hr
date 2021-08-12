<?php

namespace App\Http\Livewire\Export;
use Livewire\Component;
use App\Exports\DayOfExport;
use App\Exports\PermissionExport;
use App\Exports\AssignmentExport;
use App\Exports\BigLeaveClaimExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Site;
class Index extends Component
{
    public $createStartDate='';
    public $createEndDate='';
    public $site='';

    public $createPermissionStartDate='';
    public $createPermissionEndDate='';
    public $sitePermission='';

    public $createAssignmentStartDate='';
    public $createAssignmentEndDate='';
    public $siteAssignment='';

    public $createBigLeaveClaimStartDate;
    public $createBigLeaveClaimEndDate;
    public $siteBigLeaveClaim;

    private $excel;
    protected $listeners=[
        'selectCreateStartDate'=>'getSelectedCreateStartDate',
        'selectCreateEndDate'=>'getSelectedCreateEndDate',
        'selectSite'=>'getSelectedSite',
        'selectCreatePermissionStartDate'=>'getSelectedCreatePermissionStartDate',
        'selectCreatePermissionEndDate'=>'getSelectedCreatePermissionEndDate',
        'selectSitePermission'=>'getSelectedSitePermission',
        'selectCreateAssignmentStartDate'=>'getSelectedCreateAssignmentStartDate',
        'selectCreateAssignmentEndDate'=>'getSelectedCreateAssignmentEndDate',
        'selectSiteAssignment'=>'getSelectedSiteAssignment',
        'selectCreateBigLeaveClaimStartDate'=>'getSelectedCreateBigLeaveClaimStartDate',
        'selectCreateBigLeaveClaimEndDate'=>'getSelectedCreateBigLeaveClaimEndDate',
        'selectSiteBigLeaveClaim'=>'getSelectedSiteBigLeaveClaim',
    ];

    public function mount(Excel $excel){
        $this->excel = $excel;
        $this->initializedProperties();
    }

    public function render(){
        $sites=Site::where('active','1')->get();
        return view('livewire.export.index',compact('sites'))->extends('layouts.app')->section('content');
    }

    public function exportDayOf()
    {
        $createStartDates= str_replace('/', '-', $this->createStartDate);
        $createEndDates= str_replace('/', '-', $this->createEndDate);
        $fileNameFors=date('ymd',strtotime($createStartDates));
        $fileNameTos=date('ymd',strtotime($createEndDates)); 
        $fileNameSites=Site::find($this->site);
        if($this->createStartDate!=null and $this->createEndDate!=null and $this->site!=null){
            return Excel::download(new DayOfExport($this->site, date('Y-m-d',strtotime($createStartDates)),date('Y-m-d',strtotime($createEndDates))),  $fileNameFors.'-'.$fileNameTos.'-'.$fileNameSites->code.'-Cuti.xlsx');
           
        }
        return redirect()->route('report-export');
    }

    public function exportPermission()
    {
        //dd($this->createPermissionStartDate.','.$this->createPermissionEndDate.','.$this->sitePermission);
        $createStartDates= str_replace('/', '-', $this->createPermissionStartDate);
        $createEndDates= str_replace('/', '-', $this->createPermissionEndDate);
        $fileNameFors=date('ymd',strtotime($createStartDates));
        $fileNameTos=date('ymd',strtotime($createEndDates)); 
        $fileNameSites=Site::find($this->sitePermission);
        if($this->createPermissionStartDate!=null and $this->createPermissionEndDate!=null and $this->sitePermission!=null){
            
            return Excel::download(new PermissionExport($this->sitePermission, date('Y-m-d',strtotime($createStartDates)),date('Y-m-d',strtotime($createEndDates))),  $fileNameFors.'-'.$fileNameTos.'-'.$fileNameSites->code.'-Izin.xlsx');
            
        }
        return redirect()->route('report-export');
    }

    public function exportAssignment()
    {
        $createStartDates= str_replace('/', '-', $this->createAssignmentStartDate);
        $createEndDates= str_replace('/', '-', $this->createAssignmentEndDate);
        $fileNameFors=date('ymd',strtotime($createStartDates));
        $fileNameTos=date('ymd',strtotime($createEndDates)); 
        $fileNameSites=Site::find($this->siteAssignment);
        if($this->createAssignmentStartDate!=null and $this->createAssignmentEndDate!=null and $this->siteAssignment!=null){
            
            return Excel::download(new AssignmentExport($this->siteAssignment, date('Y-m-d',strtotime($createStartDates)),date('Y-m-d',strtotime($createEndDates))),  $fileNameFors.'-'.$fileNameTos.'-'.$fileNameSites->code.'-Dinas.xlsx');
            
        }
        return redirect()->route('report-export');
    }

    public function exportBigLeaveClaim()
    {
       //dd($this->createBigLeaveClaimStartDate);
       
        $createStartDates= str_replace('/', '-', $this->createBigLeaveClaimStartDate);
        $createEndDates= str_replace('/', '-', $this->createBigLeaveClaimEndDate);
        $fileNameFors=date('ymd',strtotime($createStartDates));
        $fileNameTos=date('ymd',strtotime($createEndDates)); 
        $fileNameSites=Site::find($this->siteBigLeaveClaim);
        if($this->createBigLeaveClaimStartDate!=null and $this->createBigLeaveClaimEndDate!=null and $this->siteBigLeaveClaim!=null){
            
            return Excel::download(new BigLeaveClaimExport($this->siteBigLeaveClaim, date('Y-m-d',strtotime($createStartDates)),date('Y-m-d',strtotime($createEndDates))),  $fileNameFors.'-'.$fileNameTos.'-'.$fileNameSites->code.'-Klaim Cuti Besar.xlsx');
            
        }
        return redirect()->route('report-export');
    }

    public function getSelectedCreateStartDate($value) {
        $this->createStartDate=$value;
    }

    public function getSelectedCreateEndDate($value) {
        $this->createEndDate=$value;
    }

    public function getSelectedSite($value) {
        $this->site=$value;
    }

    public function getSelectedCreatePermissionStartDate($value) {
        $this->createPermissionStartDate=$value;
    }

    public function getSelectedCreatePermissionEndDate($value) {
        $this->createPermissionEndDate=$value;
    }

    public function getSelectedSitePermission($value) {
        $this->sitePermission=$value;
    }

    public function getSelectedCreateAssignmentStartDate($value) {
        $this->createAssignmentStartDate=$value;
    }

    public function getSelectedCreateAssignmentEndDate($value) {
        $this->createAssignmentEndDate=$value;
    }

    public function getSelectedSiteAssignment($value) {
        $this->siteAssignment=$value;
    }

    public function getSelectedCreateBigLeaveClaimStartDate($value) {
        $this->createBigLeaveClaimStartDate=$value;
    }

    public function getSelectedCreateBigLeaveClaimEndDate($value) {
        $this->createBigLeaveClaimEndDate=$value;
    }

    public function getSelectedSiteBigLeaveClaim( $value) {
        $this->siteBigLeaveClaim=$value;
    }
    
    private function initializedProperties(){
        $this->createStartDate=null;
        $this->createEndDate=null;
        $this->site=null;
        $this->createPermissionStartDate=null;
        $this->createPermissionEndDate=null;
        $this->sitePermission=null;

        $this->createAssignmentStartDate=null;
        $this->createAssignmentEndDate=null;
        $this->siteAssignment=null;

        $this->createBigLeaveClaimStartDate=null;
        $this->createBigLeaveClaimEndDate=null;
        $this->siteBigLeaveClaim=null;
    }
}
