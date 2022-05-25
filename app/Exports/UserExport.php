<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\User;

class UserExport implements FromView, WithEvents
{
    protected $level;
    protected $status;

    function __construct($level, $status) {
        $this->level = $level;
        $this->status = $status;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(15);

            },
        ];
    }

    public function view(): View
    {
        if(is_numeric($this->level) && is_numeric($this->status)){
            $data = User::where([['level', $this->level], ['status', $this->status]])->get();
        }
        else if(is_numeric($this->level)){
            $data = User::where('level', $this->level)->get();
        }
        else if(is_numeric($this->status)){
            $data = User::where('status', $this->status)->get();
        }
        else {
            $data = User::get();
        }

        return view('Users.Pages._excel', [
            'level'  => User::level($this->level),
            'status' => User::status($this->status),
            'data'   => $data
        ]);
    }
}
