<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

include_once __DIR__ . '/Common.php';

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    public static function MiladyToShamsi3($ts){
        include_once 'jdate.php';
        return jdate('l d F سال Y - H:m', "", $ts);
    }

    public static function MiladyToShamsi($date, $explode='-'){
        include_once 'jdate.php';
        $d = explode($explode, $date);
        return gregorian_to_jalali($d[0],$d[1],$d[2],'/');
    }

    public static function MiladyToShamsi2($ts){
        include_once 'jdate.php';
        return jdate('l d F سال Y', "", $ts);
    }
    
    
    public static function MiladyToShamsi4($ts){
        include_once 'jdate.php';
        return jdate('Y/m/d', "", $ts);
    }

    public static function formatSecondsToHMS($seconds) {
        // Ensure input is non-negative
        $seconds = max(0, (int)$seconds);

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        // Format with leading zeros
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }
}
