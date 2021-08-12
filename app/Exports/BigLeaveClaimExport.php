<?php

namespace App\Exports;

use App\Models\BigLeaveClaim;
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

class BigLeaveClaimExport implements
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

            return BigLeaveClaim::query()->select('big_leave_claims.number','big_leave_claims.user_id','big_leave_claims.site_id','big_leave_claims.big_leave_id'
                ,'big_leave_claims.year','big_leave_claims.multiplier_salary','big_leave_claims.paid' 
                ,'e.start','e.end','e.sum','e.description','e.take'
                ,'big_leave_claims.head_approv','big_leave_claims.sm_approv','big_leave_claims.hrd_approv','big_leave_claims.approv','big_leave_claims.active','big_leave_claims.created_at'
                ,'a.nrp','a.name','a.position_id','b.name as site','c.name as position','c.department_id','d.name as department'
                )                
                ->join('users as a', 'a.id', '=', 'big_leave_claims.user_id')
                ->join('sites as b', 'big_leave_claims.site_id', '=', 'b.id')
                ->join('positions as c', 'a.position_id', '=', 'c.id')
                ->join('departments as d', 'c.department_id', '=', 'd.id')
                ->join('big_leaves as e', 'big_leave_claims.big_leave_id', '=', 'e.id')
                ->whereBetween('big_leave_claims.created_at', [$this->createStartDate, $this->createEndDate])   
                ->where('big_leave_claims.site_id', $this->site)
                ->where('big_leave_claims.active','1')
                ->where('e.take','0')
                ->where('big_leave_claims.approv','1')
                ;
    }

    public function map($bigLeaveClaims): array
    {
        if($bigLeaveClaims->paid=='1'){
            $checkPaids="Terbayar";
        }else{
            $checkPaids="";
        }
        return [
            date('d/m/Y',strtotime($bigLeaveClaims->created_at)),
            trim($bigLeaveClaims->number),
            $bigLeaveClaims->nrp,
            $bigLeaveClaims->name,
            $bigLeaveClaims->position,
            $bigLeaveClaims->department,
            $bigLeaveClaims->site,
            $bigLeaveClaims->year,
            date('d/m/Y',strtotime($bigLeaveClaims->start)),
            date('d/m/Y',strtotime($bigLeaveClaims->end)),
            $bigLeaveClaims->sum,
            'Tidak ambil',
            $bigLeaveClaims->multiplier_salary,
            $checkPaids,
            trim($bigLeaveClaims->description),
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
            'Jml Hari',
            'Cuti',
            'Pengali Gapok',
            'Status Bayar',
            'Keterangan'
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
       // $drawing->setPath(public_path('/template/dist/img/logo/logo.png'));
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
        return "Klaum Cuti Besar";
    }
}