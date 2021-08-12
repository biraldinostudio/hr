<?php

namespace App\Exports;

use App\Models\DayOf;
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

class DayOfExport implements
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    WithEvents,
    FromQuery,
    WithDrawings,
    WithCustomStartCell,
    WithTitle
   // WithProperties
{
    use Exportable;

    private $year;
    private $month;
    public $createStartDate;
    public $createEndDate;
    public $site;
    
   // public function __construct(int $year, int $month, int $site, $createStartDate,$createEndDate)
    public function __construct(int $site, $createStartDate,$createEndDate)
    {
        //$this->year = $year;
       // $this->month = $month;
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
        //return  DayOf::query()

        return DayOf::query()->select('day_ofs.number','day_ofs.id','day_ofs.user_id','day_ofs.site_id','day_ofs.poh_id','day_ofs.start','day_ofs.end','day_ofs.in','day_ofs.work_day'
            ,'day_ofs.day_of_sum','day_ofs.day_of_total','day_ofs.day_of_grandtotal','day_ofs.day_of_standart','day_ofs.day_of_should','day_ofs.day_of_less'
            ,'day_ofs.travel_from_go','day_ofs.travel_from_back','day_ofs.ticket_from_go','day_ofs.ticket_from_back'
            ,'day_ofs.travel_day_go','day_ofs.travel_day_back','day_ofs.lumpsum'
            ,'f.start as AStart','f.end as AEnd','f.standart as AStandart','f.should as AShould','f.sum as ASum','f.less as ALess'
            ,'g.start as BStart','g.end as BEnd','g.standart as BStandart','g.should as BShould','g.sum as BSum','g.less as BLess'
            ,'day_ofs.head_approv','day_ofs.sm_approv','day_ofs.hrd_approv','day_ofs.approv','day_ofs.active','day_ofs.created_at'
                ,'a.nrp','a.name','a.position_id','b.name as site','c.name as position','c.department_id','d.name as department','e.name as poh'
                )                
                ->join('users as a', 'a.id', '=', 'day_ofs.user_id')
                ->join('sites as b', 'day_ofs.site_id', '=', 'b.id')
                ->join('positions as c', 'a.position_id', '=', 'c.id')
                ->join('departments as d', 'c.department_id', '=', 'd.id')
                ->join('pohs as e', 'day_ofs.poh_id', '=', 'e.id')
                ->leftjoin('annual_leaves as f', 'day_ofs.id', '=', 'f.day_of_id')
                ->leftjoin('big_leaves as g', 'day_ofs.id', '=', 'g.day_of_id')
            ->whereBetween('day_ofs.created_at', [$this->createStartDate, $this->createEndDate])   
             ->where('day_ofs.site_id', $this->site)
             ->where('day_ofs.active','1')
             ->where('day_ofs.approv','1')
            ;
    }

    public function map($dayofs): array
    {
        if($dayofs->AStart==null) {
            $AStarts='';
            $AEnds='';
        } else{
            $AStarts=date('d/m/Y',strtotime($dayofs->AStart));
            $AEnds=date('d/m/Y',strtotime($dayofs->AEnd));
        }

        if($dayofs->BStart==null) {
            $BStarts='';
            $BEnds='';
        } else{
            $BStarts=date('d/m/Y',strtotime($dayofs->BStart));
            $BEnds=date('d/m/Y',strtotime($dayofs->BEnd));
        }

        if($dayofs->ticket_from_go==null) {
            $ticketDateFromGos='';
            $ticketDateFromBacks='';
        } else{
            $ticketDateFromGos=date('d/m/Y',strtotime($dayofs->ticket_from_go));
            $ticketDateFromBacks=date('d/m/Y',strtotime($dayofs->ticket_from_back));
        }

        if($dayofs->travel_from_go==null) {
            $travelDateFromGos='';
            $travelDateFromBacks='';
        } else{
            $travelDateFromGos=date('d/m/Y',strtotime($dayofs->travel_from_go));
            $travelDateFromBacks=date('d/m/Y',strtotime($dayofs->travel_from_back));
        }

        return [
            date('d/m/Y',strtotime($dayofs->created_at)),
            trim($dayofs->number),
            $dayofs->nrp,
            $dayofs->name,
            $dayofs->position,
            $dayofs->department,
            $dayofs->site,
            date('d/m/Y',strtotime($dayofs->start)),
            date('d/m/Y',strtotime($dayofs->end)),
            date('d/m/Y',strtotime($dayofs->in)),
            $dayofs->work_day,
            $dayofs->day_of_standart,
            $dayofs->day_of_sum,
            $dayofs->day_of_total,
            $dayofs->day_of_grandtotal,
            $dayofs->day_of_less,
            $dayofs->lumpsum,
            $travelDateFromGos,
            $travelDateFromBacks,
            $ticketDateFromGos,
            $ticketDateFromBacks, 
            $AStarts,
            $AEnds,
            $dayofs->AStandart,
            $dayofs->ASum,
            $dayofs->ALess,
            $BStarts,
            $BEnds,
            $dayofs->BStandart,
            $dayofs->BSum,
            $dayofs->BLess,
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
            'Masuk/Induksi',
            'Jam Kerja',
            'Standart',
            'Jml Hari',
            'Total Hari',
            'GrandTotal Hari',
            'Sisa Hari',
            'TglBerangkatTravel',
            'TglKembaliTravel',			
            'TglBerangkatTiket',
            'TglKembaliTiket',
            'Lumpsum',
            'CTTahunanMulai',
            'CTTahunanSelesai',
            'CTTahunanStandart',
            'CTTahunanJML',
            'CTTahunanSisa',
            'CTBesarMulai',
            'CTBesarSelesai',
            'CTBesarStandart',
            'CTBesarJML',
            'CTBesarSisa'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A5:AE5')->applyFromArray([
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
        //storage_path('app/public/image/'. $filename)
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
        //Nama sheet
        //return DateTime::createFromFormat('!m', $this->month)->format('F');
        return "Cuti";
    }
}