<?php


namespace App\Utilities;

use Carbon\Carbon;

trait DateFormatter{

    public static function dateFormat($format = 'Y-m-d\TH:i:s\Z') : array {
        
        $yesterday = Carbon::yesterday();
        $from = $yesterday->format($format);
        
        $today = $yesterday->addDay();
        $to = $today->format($format);
        
        return [
            'from'  =>  $from,
            'to'    =>  $to
        ];
    } 
}