<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\Changelogs;

class ChangelogsExport implements FromView, WithEvents
{
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getStyle('B')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
                $event->sheet->getStyle('C')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
            },
        ];
    }

    public function view(): View
    {
        return view('Changelogs.Pages._excel', [
            'data' => Changelogs::with('user')->find($this->id)
        ]);
    }
}
