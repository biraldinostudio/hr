<?php

namespace App\Http\Livewire\Export;
use Livewire\Component;
use App\Exports\PermissionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Site;
class Permission extends Component
{
    public $createStartDate='';
    public $createEndDate='';
    public $site='';
    private $excel;
    protected $listeners=[
        'selectCreateStartDate'=>'getSelectedCreateStartDate',
        'selectCreateEndDate'=>'getSelectedCreateEndDate',
        'selectSite'=>'getSelectedSite',
    ];

    public function mount(Excel $excel){
        $this->excel = $excel;
        $this->initializedProperties();
    }

    public function render(){
        $sites=Site::where('active','1')->get();
        return view('livewire.export.permission',compact('sites'));
    }

    public function exportPermission()
    {
        $createStartDates= str_replace('/', '-', $this->createStartDate);
        $createEndDates= str_replace('/', '-', $this->createEndDate);
        $fileNameFors=date('ymd',strtotime($createStartDates));
        $fileNameTos=date('ymd',strtotime($createEndDates)); 
        $fileNameSites=Site::find($this->site);
        if($this->createStartDate!=null and $this->createEndDate!=null and $this->site!=null){
            return Excel::download(new PermissionExport($this->site, date('Y-m-d',strtotime($createStartDates)),date('Y-m-d',strtotime($createEndDates))),  $fileNameFors.'-'.$fileNameTos.'-'.$fileNameSites->code.'-Izin.xlsx');
            return redirect()->route('permission-export');
        }
    }

    public function getSelectedCreateStartDate( $value) {
        $this->createStartDate=$value;
    }

    public function getSelectedCreateEndDate( $value) {
        $this->createEndDate=$value;
    }

    public function getSelectedSite( $value) {
        $this->site=$value;
    }

    private function initializedProperties(){
        $this->createStartDate=null;
        $this->createEndDate=null;
        $this->site=null;
    }
}
