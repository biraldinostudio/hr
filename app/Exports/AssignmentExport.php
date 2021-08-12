<?php

namespace App\Exports;

use App\Models\Assignment;
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

class AssignmentExport implements
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

        return Assignment::query()->select('assignments.number','assignments.id','assignments.user_id','assignments.site_id','assignments.start_date'
			,'assignments.end_date','assignments.in_date','assignments.sum_day','assignments.travel_date_from_go','assignments.travel_date_from_back'
			,'assignments.ticket_date_from_go','assignments.ticket_date_from_back','assignments.lodging_day','assignments.lodging_cost'
			,'assignments.transportation_day','assignments.transportation_cost','assignments.meal_day','assignments.meal_cost'
			,'assignments.other_day','assignments.other_cost','assignments.approv','assignments.active','assignments.created_at'
                ,'a.nrp','a.name','a.position_id','b.name as site','c.name as position','c.department_id','d.name as department'
                )                
                ->join('users as a', 'a.id', '=', 'assignments.user_id')
                ->join('sites as b', 'assignments.site_id', '=', 'b.id')
                ->join('positions as c', 'a.position_id', '=', 'c.id')
                ->join('departments as d', 'c.department_id', '=', 'd.id')
            ->whereBetween('assignments.created_at', [$this->createStartDate, $this->createEndDate])   
             ->where('assignments.site_id', $this->site)
             ->where('assignments.active','1')
             ->where('assignments.approv','1')
            ;
    }

    public function map($assignments): array
    {

        if($assignments->ticket_from_go==null) {
            $ticketDateFromGos='';
            $ticketDateFromBacks='';
        } else{
            $ticketDateFromGos=date('d/m/Y',strtotime($assignments->ticket_date_from_go));
            $ticketDateFromBacks=date('d/m/Y',strtotime($assignments->ticket_date_from_back));
        }

        if($assignments->travel_from_go==null) {
            $travelDateFromGos='';
            $travelDateFromBacks='';
        } else{
            $travelDateFromGos=date('d/m/Y',strtotime($assignments->travel_date_from_go));
            $travelDateFromBacks=date('d/m/Y',strtotime($assignments->travel_date_from_back));
        }

        return [
            date('d/m/Y',strtotime($assignments->created_at)),
            trim($assignments->number),
            $assignments->nrp,
            $assignments->name,
            $assignments->position,
            $assignments->department,
            $assignments->site,
            date('d/m/Y',strtotime($assignments->start)),
            date('d/m/Y',strtotime($assignments->end)),
            date('d/m/Y',strtotime($assignments->in)),
            $assignments->sum_day,
            $travelDateFromGos,
            $travelDateFromBacks,
            $ticketDateFromGos,
            $ticketDateFromBacks,
			$assignments->lodging_day,
			$assignments->lodging_cost,
			$assignments->transportation_day,
			$assignments->transportation_cost,
			$assignments->meal_day,
			$assignments->meal_cost,
			$assignments->other_day,
			$assignments->other_cost,			
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
            'Jml Hari',
            'TglBerangkatTravel',
            'TglKembaliTravel',			
            'TglBerangkatTiket',
            'TglKembaliTiket',
			'HariPenginapan',
			'BiayaPenginapan',
			'HariTransport',
			'BiayaTransport',
			'HariMakan',
			'BiayaMakan',
			'HariLain2',
			'BiayaLain2'
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
        return "Dinas";
    }
}