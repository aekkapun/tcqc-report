<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "veh_test_report_detail".
 *
 * @property int $id รหัสรายการ (Primary Key)
 * @property int $schedule_id อ้างอิงถึง ID ในตาราง car_test_report_schedule
 * @property string $report_month เดือนที่ต้องรายงาน (รูปแบบ YYYY-MM)
 * @property string|null $test_date_from วันที่เริ่มทดสอบในรอบรายงานนี้
 * @property string|null $test_date_to วันที่สิ้นสุดทดสอบในรอบรายงานนี้
 * @property float|null $test_distance ระยะทางที่ใช้ทดสอบในเดือนนี้ (กิโลเมตร)
 * @property float|null $test_time เวลาที่ใช้ทดสอบในเดือนนี้ (ชั่วโมง)
 * @property string|null $test_location สถานที่ทดสอบ
 * @property string|null $test_purpose วัตถุประสงค์การทดสอบ
 * @property string|null $test_result ผลการทดสอบ
 * @property string|null $report_file ไฟล์แนบรายงาน (ถ้ามี)
 * @property string|null $remarks หมายเหตุเพิ่มเติมสำหรับรายงานนี้
 * @property string|null $created_at วันที่สร้างข้อมูล
 * @property string|null $updated_at วันที่อัปเดตข้อมูลล่าสุด
 * @property int|null $created_by ผู้สร้างข้อมูล
 * @property int|null $updated_by ผู้แก้ไขข้อมูลล่าสุด
 *
 * @property VehTestReportSchedule $schedule
 */
class VehTestReportDetail extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'veh_test_report_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_date_from', 'test_date_to', 'test_distance', 'test_time', 'test_location', 'test_purpose', 'test_result', 'report_file', 'remarks', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['schedule_id'], 'required'],
            [['schedule_id', 'created_by', 'updated_by'], 'integer'],
            [['test_date_from', 'test_date_to', 'created_at', 'updated_at'], 'safe'],
            [['test_distance', 'test_time'], 'number'],
            [['report_month'], 'string', 'max' => 7],
            [['test_location', 'test_purpose', 'test_result', 'remarks'], 'string'],
            [['report_file'], 'string', 'max' => 255],
            [['schedule_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehTestReportSchedule::class, 'targetAttribute' => ['schedule_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัสรายการ (Primary Key)',
            'schedule_id' => 'อ้างอิงถึง ID ในตาราง car_test_report_schedule',
            'report_month' => 'เดือนที่ต้องรายงาน (รูปแบบ YYYY-MM)',
            'test_date_from' => 'วันที่เริ่มทดสอบในรอบรายงานนี้',
            'test_date_to' => 'วันที่สิ้นสุดทดสอบในรอบรายงานนี้',
            'test_distance' => 'ระยะทางที่ใช้ทดสอบในเดือนนี้ (กิโลเมตร)',
            'test_time' => 'เวลาที่ใช้ทดสอบในเดือนนี้ (ชั่วโมง)',
            'test_location' => 'สถานที่ทดสอบ',
            'test_purpose' => 'วัตถุประสงค์การทดสอบ',
            'test_result' => 'ผลการทดสอบ',
            'report_file' => 'ไฟล์แนบรายงาน (ถ้ามี)',
            'remarks' => 'หมายเหตุเพิ่มเติมสำหรับรายงานนี้',
            'created_at' => 'วันที่สร้างข้อมูล',
            'updated_at' => 'วันที่อัปเดตข้อมูลล่าสุด',
            'created_by' => 'ผู้สร้างข้อมูล',
            'updated_by' => 'ผู้แก้ไขข้อมูลล่าสุด',
        ];
    }


    /**
     * Gets query for [[Schedule]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(VehTestReportSchedule::class, ['id' => 'schedule_id']);
    }

}
