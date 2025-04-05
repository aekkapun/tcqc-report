<?php

namespace app\models;

use Yii;


class Thaidate {

   protected $date;
    protected $thaiTimezone = 'Asia/Bangkok';
    public function __construct($date)
    {       
        $this->date = new \DateTime($date, new \DateTimeZone($this->thaiTimezone));
    }
    private function getThaiDay($index)
    {
        $ThDayOfWeek = array(
            'อาทิตย์',
            'จันทร์',
            'อังคาร',
            'พุธ',
            'พฤหัสบดี',
            'ศุกร์',
            'เสาร์',
            'อาทิตย์'
            );
        return $ThDayOfWeek[$index];
    }
    private function getThaiMonth($index)
    {
        $ThMonth = array(
            'มกราคม',
            'กุมภาพันธ์',
            'มีนาคม',
            'เมษายน',
            'พฤษภาคม',
            'มิถุนายน',
            'กรกฎาคม',
            'สิงหาคม',
            'กันยายน',
            'ตุลาคม',
            'พฤศจิกายน',
            'ธันวาคม'
            );
        return $ThMonth[$index-1];
    }
    public function getPHPDateObject()
    {
        return $this->date;
    }
    public function getTimezone()
    {
        return $this->date->getTimezone()->getName();
    }
    public function getDayOfWeek()
    {
        return $this->getThaiDay($this->date->format('w'));
    }
    public function getMonth()
    {
        return $this->getThaiMonth($this->date->format('n'));
    }
    public function getYear()
    {
        return intval($this->date->format('Y'))+543;
    }
    private function thaiFormatReplace($format)
    {
        $pattern = array(
            '/::ThDay::/',
            '/::ThMonth::/',
            '/::ThYear::/'
            );
        $replacement = array(
            self::getDayOfWeek(),
            self::getMonth(),
            self::getYear()
            );
        $newformat = preg_replace($pattern, $replacement, $format);
        return $newformat;
    }
    public function format($format)
    {
        return $this->date->format(
            $this->thaiFormatReplace($format)
            );
    }
}
