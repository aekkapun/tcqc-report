<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "veh_test_report_schedule".
 *
 * @property int $id รหัสรายการ (Primary Key)
 * @property string $OFF_CODE หน่วยงานออกหนังสืออนุญาตฯ-จังหวัด
 * @property string $BR_CODE หน่วยงานออกหนังสืออนุญาตฯ-สาขา
 * @property string $CAR_TEST_TYPE ประเภทรถทดสอบ T = ก่อนผลิต Q = คุณภาพ
 * @property string $CERT_YEAR ปี พ.ศ. ของหนังสืออนุญาต
 * @property string $CERT_NO เลขที่หนังสืออนุญาต (อักษร+เลขลำดับ)
 * @property string $PLATE1 หมวดอักษรของเลขที่เครื่องหมาย
 * @property string $PLATE2 เลขที่เครื่องหมาย (อักษร+เลขลำดับ)
 * @property int $PLATE_SEQ ลำดับรายการของเครื่องหมาย
 * @property string $report_date วันที่ต้องรายงาน (วันที่ 15 ของเดือนถัดไป)
 * @property string $report_month เดือนที่ต้องรายงาน (รูปแบบ YYYY-MM)
 * @property string|null $report_status สถานะการรายงาน
 * @property string|null $actual_report_date วันที่รายงานจริง (ถ้ามี)
 * @property int|null $is_fined มีการปรับหรือไม่ (TRUE=ถูกปรับ, FALSE=ไม่ถูกปรับ)
 * @property float|null $fine_amount จำนวนค่าปรับ (ถ้ามี)
 * @property string|null $fine_payment_status สถานะการจ่ายค่าปรับ
 * @property string|null $fine_payment_date วันที่จ่ายค่าปรับ (ถ้ามี)
 * @property string|null $fine_receipt_no เลขที่ใบเสร็จค่าปรับ (ถ้ามี)
 * @property string|null $remarks หมายเหตุเพิ่มเติม
 * @property string|null $created_at วันที่สร้างข้อมูล
 * @property string|null $updated_at วันที่อัปเดตข้อมูลล่าสุด
 * @property int|null $created_by ผู้สร้างข้อมูล
 * @property int|null $updated_by ผู้แก้ไขข้อมูลล่าสุด
 *
 * @property VehTestReportDetail[] $vehTestReportDetails
 */
class VehTestReportSchedule extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const REPORT_STATUS_PENDING = 'pending';
    const REPORT_STATUS_REPORTED = 'reported';
    const REPORT_STATUS_LATE = 'late';
    const REPORT_STATUS_MISSED = 'missed';
    const FINE_PAYMENT_STATUS_UNPAID = 'unpaid';
    const FINE_PAYMENT_STATUS_PAID = 'paid';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'veh_test_report_schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['actual_report_date', 'fine_payment_date', 'fine_receipt_no', 'remarks', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['report_status'], 'default', 'value' => 'pending'],
            [['is_fined'], 'default', 'value' => 0],
            [['fine_amount'], 'default', 'value' => 0.00],
            [['fine_payment_status'], 'default', 'value' => 'unpaid'],
            [['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO', 'PLATE1', 'PLATE2', 'report_date', 'report_month'], 'required'],
            [['PLATE_SEQ', 'is_fined', 'created_by', 'updated_by'], 'integer'],
            [['report_date', 'actual_report_date', 'fine_payment_date', 'created_at', 'updated_at'], 'safe'],
            [['report_status', 'fine_payment_status', 'remarks'], 'string'],
            [['fine_amount'], 'number'],
            [['OFF_CODE', 'BR_CODE', 'PLATE1'], 'string', 'max' => 10],
            [['CAR_TEST_TYPE'], 'string', 'max' => 1],
            [['CERT_YEAR'], 'string', 'max' => 4],
            [['CERT_NO', 'PLATE2'], 'string', 'max' => 20],
            [['report_month'], 'string', 'max' => 7],
            [['fine_receipt_no'], 'string', 'max' => 50],
            ['report_status', 'in', 'range' => array_keys(self::optsReportStatus())],
            ['fine_payment_status', 'in', 'range' => array_keys(self::optsFinePaymentStatus())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัสรายการ (Primary Key)',
            'OFF_CODE' => 'หน่วยงานออกหนังสืออนุญาตฯ-จังหวัด',
            'BR_CODE' => 'หน่วยงานออกหนังสืออนุญาตฯ-สาขา',
            'CAR_TEST_TYPE' => 'ประเภทรถทดสอบ T = ก่อนผลิต Q = คุณภาพ',
            'CERT_YEAR' => 'ปี พ.ศ. ของหนังสืออนุญาต',
            'CERT_NO' => 'เลขที่หนังสืออนุญาต (อักษร+เลขลำดับ)',
            'PLATE1' => 'หมวดอักษรของเลขที่เครื่องหมาย',
            'PLATE2' => 'เลขที่เครื่องหมาย (อักษร+เลขลำดับ)',
            'PLATE_SEQ' => 'ลำดับรายการของเครื่องหมาย',
            'report_date' => 'วันที่ต้องรายงาน (วันที่ 15 ของเดือนถัดไป)',
            'report_month' => 'เดือนที่ต้องรายงาน (รูปแบบ YYYY-MM)',
            'report_status' => 'สถานะการรายงาน',
            'actual_report_date' => 'วันที่รายงานจริง (ถ้ามี)',
            'is_fined' => 'มีการปรับหรือไม่ (TRUE=ถูกปรับ, FALSE=ไม่ถูกปรับ)',
            'fine_amount' => 'จำนวนค่าปรับ (ถ้ามี)',
            'fine_payment_status' => 'สถานะการจ่ายค่าปรับ',
            'fine_payment_date' => 'วันที่จ่ายค่าปรับ (ถ้ามี)',
            'fine_receipt_no' => 'เลขที่ใบเสร็จค่าปรับ (ถ้ามี)',
            'remarks' => 'หมายเหตุเพิ่มเติม',
            'created_at' => 'วันที่สร้างข้อมูล',
            'updated_at' => 'วันที่อัปเดตข้อมูลล่าสุด',
            'created_by' => 'ผู้สร้างข้อมูล',
            'updated_by' => 'ผู้แก้ไขข้อมูลล่าสุด',
        ];
    }

    /**
     * Gets query for [[VehTestReportDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehTestReportDetails()
    {
        return $this->hasMany(VehTestReportDetail::class, ['schedule_id' => 'id']);
    }


    /**
     * column report_status ENUM value labels
     * @return string[]
     */
    public static function optsReportStatus()
    {
        return [
            self::REPORT_STATUS_PENDING => '<i class="fa fa-circle" aria-hidden="true" style="color: #521607FF"></i> ยังไม่รายงาน',
            self::REPORT_STATUS_REPORTED => '<i class="fa fa-circle" aria-hidden="true" style="color: #0D9E0DFF"></i> รายงานแล้ว',
            self::REPORT_STATUS_LATE => '<i class="fa fa-circle" aria-hidden="true" style="color: #B98003FF"></i> ล่าช้า',
            self::REPORT_STATUS_MISSED => '<i class="fa fa-circle" aria-hidden="true" style="color: #BB0000FF"></i> ไม่รายงาน',
        ];
    }
    public function getReportFlag()
    {
        switch ($this->report_status) {
            case 'pending':
                return '<i class="fa fa-circle" aria-hidden="true" style="color: #300E05FF"></i> ยังไม่รายงาน';
            case 'reported':
                return '<i class="fa fa-circle" aria-hidden="true" style="color: #0D9E0DFF"></i> รายงานแล้ว';
            case 'late':
                return '<i class="fa fa-circle" aria-hidden="true" style="color: #B98003FF"></i> ล่าช้า';
            case 'missed':
                return '<i class="fa fa-circle" aria-hidden="true" style="color: #BB0000FF"></i> ไม่รายงาน ';
        }
        return NULL;
    }
    /**
     * column fine_payment_status ENUM value labels
     * @return string[]
     */
    public static function optsFinePaymentStatus()
    {
        return [
            self::FINE_PAYMENT_STATUS_UNPAID => 'unpaid',
            self::FINE_PAYMENT_STATUS_PAID => 'paid',
        ];
    }

    /**
     * @return string
     */
    public function displayReportStatus()
    {
        return self::optsReportStatus()[$this->report_status];
    }

    /**
     * @return bool
     */
    public function isReportStatusPending()
    {
        return $this->report_status === self::REPORT_STATUS_PENDING;
    }

    public function setReportStatusToPending()
    {
        $this->report_status = self::REPORT_STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isReportStatusReported()
    {
        return $this->report_status === self::REPORT_STATUS_REPORTED;
    }

    public function setReportStatusToReported()
    {
        $this->report_status = self::REPORT_STATUS_REPORTED;
    }

    /**
     * @return bool
     */
    public function isReportStatusLate()
    {
        return $this->report_status === self::REPORT_STATUS_LATE;
    }

    public function setReportStatusToLate()
    {
        $this->report_status = self::REPORT_STATUS_LATE;
    }

    /**
     * @return bool
     */
    public function isReportStatusMissed()
    {
        return $this->report_status === self::REPORT_STATUS_MISSED;
    }

    public function setReportStatusToMissed()
    {
        $this->report_status = self::REPORT_STATUS_MISSED;
    }

    /**
     * @return string
     */
    public function displayFinePaymentStatus()
    {
        return self::optsFinePaymentStatus()[$this->fine_payment_status];
    }

    /**
     * @return bool
     */
    public function isFinePaymentStatusUnpaid()
    {
        return $this->fine_payment_status === self::FINE_PAYMENT_STATUS_UNPAID;
    }

    public function setFinePaymentStatusToUnpaid()
    {
        $this->fine_payment_status = self::FINE_PAYMENT_STATUS_UNPAID;
    }

    /**
     * @return bool
     */
    public function isFinePaymentStatusPaid()
    {
        return $this->fine_payment_status === self::FINE_PAYMENT_STATUS_PAID;
    }

    public function setFinePaymentStatusToPaid()
    {
        $this->fine_payment_status = self::FINE_PAYMENT_STATUS_PAID;
    }

    public function getCarTestType()
    {
        switch ($this->CAR_TEST_TYPE) {
            case 'T':
                return 'รถทดสอบก่อนผลิต ';
            case 'Q':
                return 'รถทดสอบคุณภาพ. ';
        }
        return NULL;
    }

    public function getEngFlag()
    {
        switch ($this->ENG_FLAG) {
            case 'E':
                return 'มอเตอร์ไฟฟ้า ';
        }
        return NULL;
    }
    public function getNUM_ENGS()
    {
        switch ($this->ENG_FLAG) {
            case 'E':
                return $this->NUM_ENG . ' (มอเตอร์ไฟฟ้า)';
        }
        return $this->NUM_ENG;
    }
    public function getCarTestType2()
    {
        switch ($this->CAR_TEST_TYPE) {
            case 'T':
                return 'TC ';
            case 'Q':
                return 'QC. ';
        }
        return NULL;
    }

    public function getMacTestVehCert()
    {
        return $this->hasOne(MacTestVehCert::className(), ['OFF_CODE' => 'OFF_CODE', 'BR_CODE' => 'BR_CODE', 'CAR_TEST_TYPE' => 'CAR_TEST_TYPE', 'CERT_YEAR' => 'CERT_YEAR', 'CERT_NO' => 'CERT_NO']);
    }

    public function getVehTestReporSchecdule()
    {
        return $this->hasOne(VehTestReportDetail::className(), ['schedule_id' => 'id', 'report_month' => 'report_month']);
    }
    public function getPlate()
    {
        // return $this->PLATE1.' '.(int)$this->PLATE2.''.$this->VEH_STATUS == 'C' ? '<p class="label label-danger">เลิกใช้</p>' : '';
        return  $this->PLATE1 . ' ' . (int)$this->PLATE2;
    }
    public function getCertNo()
    {
        return $this->CAR_TEST_TYPE . 'C' . (int)$this->CERT_NO . "/" . $this->CERT_YEAR;
    }
}
