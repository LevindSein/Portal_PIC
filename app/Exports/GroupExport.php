<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\Group;

class GroupExport implements FromView, WithEvents
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(30);
                $event->sheet->getStyle('D')->getAlignment()->setWrapText(true);
            },
        ];
    }

    public function view(): View
    {
        $data = Group::orderBy('blok', 'asc')->orderByRaw('LENGTH(nicename), nicename')->orderBy('nomor', 'asc')->get();

        return view('MasterData.Group.Pages._excel', [
            'data' => $data
        ]);
    }
}
