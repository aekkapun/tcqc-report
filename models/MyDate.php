<?php
namespace app\models;
use DateTime;

class MyDate
{
    public function getMonth($month) {
        switch ($month) {
            case '01':return 'มกราคม';
            case '02':return 'กุมภาพันธ์ ';
            case '03': return 'มีนาคม ';
            case '04':return 'เมษายน ';
            case '05': return 'พฤษภาคม ';
            case '06':return 'มิถุนายน ';
            case '07':return 'กรกฎาคม ';
            case '08':return 'สิงหาคม ';
            case '09':return 'กันยายน ';
            case '10':return 'ตุลาคม ';
            case '11':return 'พฤศจิกายน ';
            case '12':return 'ธันวาคม ';
        }
        return NULL;
    }

    public static function getShort($month) {
        $mnt = ereg_replace('[[:space:]]+', ' ', trim($month));
        switch ($mnt) {
            case 'ก.ค.':return '01';break;
            case 'ก.พ.':return '02 ';break;
            case 'มี.ค.': return '03 ';break;
            case 'เม.ย.':return '04 ';break;
            case 'พ.ค.': return '05 ';break;
            case 'มิ.ย.':return '06. ';break;
            case 'ก.ค.':return '07 ';break;
            case 'ส.ค.':return '08 ';break;
            case 'ก.ย.':return '09 ';break;
            case 'ต.ค.':return '10 ';break;
            case 'พ.ย.':return '11 ';break;
            case 'ธ.ค.':return '12 ';break;
        }
        return NULL;
    }
    public static function getDateNation($date){
        $dd = substr($date,0,2);
        $yyyy = substr($date,-4);
        $m = preg_replace('/[0-9]+/', '', $date);
        $mm =self::getShort($m);
        $str_date =  $yyyy.'-'.self::getShort($m).'-'.$dd;
        $date = new DateTime($str_date);
        $date_format = date_format($date,"Y-m-d H:i:s");
        return $date_format;
    }

    public static function getDateThai($date){
        $d = substr($date, -2);
        $m = substr($date, -4,2);
        $y = substr($date, -8, 4);
        // $time = $y.'-'.$m.'-'.$d;
        // $date = new DateTime($time);
        $revert = $d.'/'.$m.'/'.$y;
        return $revert;
    }
    public static function getTimeFormat($time){
        $h = substr($time, 0,2);
        $m = substr($time, 2,2);
        $s = substr($time,  4, 2);
        // $time = $y.'-'.$m.'-'.$d;
        // $date = new DateTime($time);
        $revert = $h.':'.$m.':'.$s;
        return $revert;
    }

    public static function getDateInt($date){
        $xdate = strtotime(date($date));
        $y = date('Y',$xdate)+543;
        $m = date('m',$xdate);
        $d = date('d',$xdate);
        $str_date =  $y.''.$m.''.$d;
        return $str_date;
    }
    public function ThaiDateFormat($date){
        $d = substr($date, -2);
        $m = substr($date, -4,2);
        $y = substr($date, -8, 4);
        // $time = $y.'-'.$m.'-'.$d;
        // $date = new DateTime($time);
        $revert = $d.'/'.$m.'/'.$y;
        return $revert;
//    $date=date_create("2013-03-15");
//    date_add($date,date_interval_create_from_date_string("40 days"));
//    echo date_format($date,"Y-m-d");

    }
    public static function ConvertDate($date){
        $xdate = strtotime(date($date));
        $y = date('Y',$xdate)+543;
        $m = date('m',$xdate);
        $d = date('d',$xdate);
        $str_date =  $y.''.$m.''.$d;
        return $str_date;
    }
}