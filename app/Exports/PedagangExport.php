<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\User;

class PedagangExport implements FromView, WithEvents
{
    protected $status;

    function __construct($status) {
        $this->status = $status;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true); //No
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true); //Username
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true); //Nama
                $event->sheet->getStyle('C')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true); //Member
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true); //KTP
                $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true); //Email
                $event->sheet->getDelegate()->getColumnDimension('G')->setAutoSize(true); //Whatsapp
                $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(true); //NPWP
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(20); //Alamat
                $event->sheet->getStyle('i')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getColumnDimension('J')->setAutoSize(true); //Status

            },
        ];
    }

    public function view(): View
    {
        if(is_numeric($this->status)){
            $data = User::where([['level', 6], ['status', $this->status]])->get();
        } else {
            $data = User::where('level', 6)->get();
        }

        return view('Services.Pedagang.Pages._excel', [
            'status' => User::status($this->status),
            'data'   => $data
        ]);
    }
}
