<?php

function convertMiladiToShamsiWithTime($miladiWithTime){

//    2018-11-24 08:24:42
    $part = explode(" ",$miladiWithTime);

    $date = explode("-",$part[0]);
    $time = explode(":",$part[1]);

    $year = $date[0];
    $month = $date[1];
    $day = $date[2];

    $hour = $time[0];
    $minute = $time[1];
    $second = $time[2];

    $mkTime = mktime($hour,$minute,$second,$month,$day,$year);

    $result = jdate("Y/m/d H:i:s",$mkTime);

    return $result;
}

function convertMiladiToShamsiWithoutTime($miladiWithoutTime){

    if ($miladiWithoutTime){
        //    2018-11-24
        $date = explode("-",$miladiWithoutTime);

        $year = $date[0];
        $month = $date[1];
        $day = $date[2];

        $hour = 0;
        $minute = 0;
        $second = 0;

        $mkTime = mktime($hour,$minute,$second,$month,$day,$year);

        $result = jdate("Y/m/d",$mkTime);

        return $result;
    } else {
        return '';
    }
}

function convertShamsiToMiladiWithTime($shamsiWithTime){

//    1397/8/15 08:24:42
    $part = explode(" ",$shamsiWithTime);

    $date = explode("/",$part[0]);
    $time = explode(":",$part[1]);

    $year = $date[0];
    $month = $date[1];
    $day = $date[2];

    $hour = $time[0];
    $minute = $time[1];
    $second = $time[2];

    $mkTime = jalali_to_gregorian($year,$month,$day);
    $result = $mkTime[0]."-".$mkTime[1]."-".$mkTime[2]." ".$hour.":".$minute.":".$second;

    return $result;
}

function makeTwoDigits($number){
    return $number<10?"0".$number:$number;
}

function convertShamsiToMiladiWithoutTime($shamsiWithoutTime){

//    1397/8/15
    $date = explode("/",$shamsiWithoutTime);

    $year = $date[0];
    $month = $date[1];
    $day = $date[2];

    $mkTime = jalali_to_gregorian($year,$month,$day);
    $result = $mkTime[0]."-".makeTwoDigits($mkTime[1])."-".makeTwoDigits($mkTime[2]);

    return $result;
}
