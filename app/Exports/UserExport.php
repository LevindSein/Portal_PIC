<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\User;

class UserExport implements FromView
{
    protected $level;

    function __construct($level) {
            $this->level = $level;
    }

    public function view(): View
    {
        if(is_numeric($this->level)){
            $level = User::level($this->level);
            $dataset = User::where([['level', $this->level], ['status', 1]])->get();
        } else {
            $level = 'Semua';
            $dataset = User::where('status', 1)->get();
        }

        return view('Users.Pages._excel', [
            'level' => $level,
            'dataset' => $dataset
        ]);
    }
}
