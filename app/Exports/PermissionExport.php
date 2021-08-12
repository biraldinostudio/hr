<?php

namespace App\Exports;

use App\Models\Permission;
use DateTime;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
//use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PermissionExport implements
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    WithEvents,
    FromQuery,
    WithDrawings,
    WithCustomStartCell,
    WithTitle
    //WithProperties
{
    use Exportable;

    private $year;
    private $month;
    public $createStartDate;
    public $createEndDate;
    public $site;

    public function __construct(int $site, $createStartDate,$createEndDate)
    {

        $this->createStartDate=$createStartDate;
        $this->createEndDate=$createEndDate;
        $this->site= $site;
    }

    /*public function properties(): array
    {
        return [
            'site_id'=>'JobSite',
            'start'        => 'Tgl Mulai',
            'end' => 'Tgl Selesai',
            'in'          => 'Tgl Masuk',
            'created_at'    => 'Tgl Buat',
        ];
    }*/

    public function query()
    {
        /*return  Permission::query()
            ->whereBetween('created_at', [$this->createStartDate, $this->createEndDate])   
             ->where('site_id', $this->site)
            ;*/

            return Permission::query()->select('permissions.number','permissions.user_id','permissions.site_id','permissions.permission_category_id','permissions.start_date','permissions.end_date','permissions.in_date','permissions.sum_day'
                ,'permissions.description','permissions.permission_category_id'
                ,'permissions.head_approv','permissions.sm_approv','permissions.hrd_approv','permissions.approv','permissions.active','permissions.created_at'
                ,'a.nrp','a.name','a.position_id','b.name as site','c.name as position','c.department_id','d.name as department'
                ,'e.id','e.name as category','e.day','e.official','e.type'
                )                
                ->join('users as a', 'a.id', '=', 'permissions.user_id')
                ->join('sites as b', 'permissions.site_id', '=', 'b.id')
                ->join('positions as c', 'a.position_id', '=', 'c.id')
                ->join('departments as d', 'c.department_id', '=', 'd.id')
                ->join('permission_categories as e', 'permissions.permission_category_id', '=', 'e.id')
                ->whereBetween('permissions.created_at', [$this->createStartDate, $this->createEndDate])   
                ->where('permissions.site_id', $this->site)
                ->where('permissions.active','1')
                ->where('permissions.approv','1')
                ;
    }

    public function map($permissions): array
    {
        if($permissions->official=='1'){
            $checkOfficials="Izin Resmi";
        }else{
            $checkOfficials="Tidak Resmi";
        }

        if($permissions->type=='CutAnnualLeave'){
            $checkTypes="Potong Cuti Tahunan";
        }elseif($permissions->type=='CutBasicSalary'){
            $checkTypes="Potong Gapok";
        }else{
            $checkTypes="";
        }
        
        return [
            date('d/m/Y',strtotime($permissions->created_at)),
            trim($permissions->number),
            $permissions->nrp,
            $permissions->name,
            $permissions->position,
            $permissions->department,
            $permissions->site,
            date('d/m/Y',strtotime($permissions->start_date)),
            date('d/m/Y',strtotime($permissions->end_date)),
            date('d/m/Y',strtotime($permissions->in_date)),
            $permissions->sum_day,
            $checkOfficials,
            $checkTypes,
            trim($permissions->category),
            $permissions->day,
            trim($permissions->description),
        ];
    }

    public function headings(): array
    {
        return [
            'TglBuat',
            'Dokumen',
            'NRP',
            'Nama',
            'Jabatan',
            'Departemen',
            'JobSite',
            'Mulai',
            'Selesai',
            'Masuk',
            'Jml Hari',
            'Jenis Izin',
            'Potong Izin',
            'Deskripsi Izin',
            'Hak Hari',
            'Keperluan'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A5:P5')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Riung Mitra Lestari');
        //$drawing->setPath(public_path('/template/dist/img/logo/logo.png'));
        $drawing->setPath(storage_path('app/public/logo/logo.png'));
        $drawing->setHeight(30);
        $drawing->setCoordinates('B2');

        return $drawing;
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function title(): string
    {
        return "Izin";
    }
}