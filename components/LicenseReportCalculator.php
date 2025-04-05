<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use DateTime;
use DateInterval;
use DatePeriod;

/**
 * คลาส LicenseReportCalculator สำหรับคำนวณวันที่รายงานการใช้เครื่องหมาย
 * 
 * @property string $startDate วันที่เริ่มต้นใช้งาน
 * @property string $endDate วันที่สิ้นสุดใช้งาน
 */
class LicenseReportCalculator extends Component
{
    /**
     * คำนวณวันที่ต้องรายงานการใช้เครื่องหมายและจำนวนวันทั้งหมดในช่วงการใช้งาน
     * 
     * @param string $startDate วันที่เริ่มต้นใช้งาน (รูปแบบ DD/MM/YYYY ในปี พ.ศ.)
     * @param string $endDate วันที่สิ้นสุดใช้งาน/ยกเลิก (รูปแบบ DD/MM/YYYY ในปี พ.ศ.)
     * @return array ข้อมูลการรายงานและจำนวนวันทั้งหมด
     */
    public function calculateReportDates($startDate, $endDate)
    {
        // แปลงรูปแบบวันที่จาก DD/MM/YYYY (พ.ศ.) เป็น DateTime object
        $start = $this->parseThaiDate($startDate);
        $end = $this->parseThaiDate($endDate);
        
        // คำนวณจำนวนวันทั้งหมดในช่วงการใช้งาน
        $interval = $start->diff($end);
        $totalDays = $interval->days + 1; // +1 เพื่อนับรวมวันสุดท้ายด้วย
        
        // คำนวณวันที่ต้องรายงาน (วันที่ 15 ของเดือนถัดไป)
        $reportDates = [];
        
        // สร้าง DateTime สำหรับวันที่ 15 ของเดือนถัดไปของวันเริ่มต้น
        $firstDay = clone $start;
        $firstDay->modify('first day of next month');
        $reportDay = clone $firstDay;
        $reportDay->setDate(
            $reportDay->format('Y'),
            $reportDay->format('m'),
            15
        );
        
        // วนลูปสร้างวันที่รายงานทั้งหมดจนถึงวันสิ้นสุด
        while ($reportDay <= $end) {
            $reportDates[] = $this->formatThaiDate($reportDay);
            
            // เลื่อนไปเดือนถัดไป
            $reportDay->modify('+1 month');
        }
        
        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDays' => $totalDays,
            'reportDates' => $reportDates
        ];
    }
    
    /**
     * แปลงวันที่จากรูปแบบ DD/MM/YYYY (พ.ศ.) เป็น DateTime object
     * 
     * @param string $dateStr วันที่ในรูปแบบ DD/MM/YYYY (พ.ศ.)
     * @return DateTime
     */
    private function parseThaiDate($dateStr)
    {
        list($day, $month, $yearBE) = explode('/', $dateStr);
        $yearAD = (int)$yearBE - 543; // แปลงปี พ.ศ. เป็น ค.ศ.
        
        return new DateTime("$yearAD-$month-$day");
    }
    
    /**
     * แปลง DateTime object เป็นรูปแบบ DD/MM/YYYY (พ.ศ.)
     * 
     * @param DateTime $date วันที่
     * @return string วันที่ในรูปแบบ DD/MM/YYYY (พ.ศ.)
     */
    private function formatThaiDate($date)
    {
        $day = $date->format('d');
        $month = $date->format('m');
        $yearAD = (int)$date->format('Y');
        $yearBE = $yearAD + 543;
        
        return "$day/$month/$yearBE";
    }
}