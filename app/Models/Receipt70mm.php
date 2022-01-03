<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt70mm extends Model
{
    use HasFactory;
    private $type;
    private $price;
    private $status;
    private $desc;

    public function __construct($type = '', $price = '', $status = true, $desc = false)
    {
        $this->type   = $type;
        $this->price  = $price;
        $this->status = $status;
        $this->desc   = $desc;
    }

    public function __toString()
    {
        if($this->status){
            if($this->desc){
                $left = str_pad($this->type, 5);
                $right = str_pad($this->price, 11, ' ', STR_PAD_LEFT);
            }
            else{
                $left = str_pad($this->type, 20);
                $right = str_pad($this->price, 20, ' ', STR_PAD_LEFT);
            }
            return "$left$right\n";
        }
        else{
            $left = str_pad('(', 10, ' ', STR_PAD_LEFT).str_pad($this->type, 6);
            $right = str_pad($this->price, 10, ' ', STR_PAD_LEFT).')';
            return "$left$right\n";
        }
    }
}
