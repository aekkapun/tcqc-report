<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mac_test_veh_cert".
 *
 * @property string $OFF_CODE หน่วยงานออกหนังสืออนุญาตฯ-จังหวัด
 * @property string $BR_CODE หน่วยงานออกหนังสืออนุญาตฯ-สาขา
 * @property string $CAR_TEST_TYPE ประเภทรถทดสอบ T = รถทดสอบก่อนผลิต Q = รถทดสอบคุณภาพ
 * @property string $CERT_YEAR เลขที่หนังสืออนุญาต-ปี พ.ศ.
 * @property string $CERT_NO เลขที่หนังสืออนุญาต- อักษร+เลขลำดับ
 * @property string|null $TEST_VEH_CODE รหัสประเภทผู้ขอหนังสืออนุญาต
 * @property string|null $TITLE_CODE คำนำหน้าชื่อผู้ขออนุญาต
 * @property string|null $ID_NO ID-NO ผู้ขออนุญาต (เลขนิติบุคคล13หลัก/เลขที่ผู้เสียภาษี)
 * @property string|null $FNAME ชื่อผู้ขออนุญาต
 * @property string|null $LNAME นามสกุลผู้ขออนุญาต
 * @property string|null $ADDR ที่ตั้ง/ที่อยู่หน่วยงาน (บ้านเลขที่/หมู่ที่/ตรอกซอย/ถนน)
 * @property string|null $DIST_CODE ตำบล/แขวง
 * @property string|null $AMP_CODE อำเภอ/เขต
 * @property string|null $PRV_CODE จังหวัด
 * @property string|null $PHONE หมายเลขโทรศัพท์ หน่วยงานที่ขอ
 * @property float|null $NUM_CAR จำนวนรถที่ขออนุญาต
 * @property float|null $NUM_PLATE จำนวนเครื่องหมายที่ขอ
 * @property string|null $INS_CODE รหัสบริษัทประกัน
 * @property string|null $INS_NO เลขที่กรมธรรม์
 * @property string|null $INS_EXP_DATE วันสิ้นอายุประกันภัย
 * @property string|null $FST_PMT_DATE วันที่อนุญาตครั้งแรก (ถ้ามี)
 * @property string|null $PMT_DATE วันที่อนุญาต
 * @property string|null $EXP_DATE วันที่สิ้นอายุ
 * @property string|null $CERT_STATUS สถานะหนังสืออนุญาตฯ A = ปกติ P = ใบแทน T = ต่ออายุ C = เลิกใช้
 * @property string|null $RENEW_DATE วันที่ต่ออายุ (ถ้ามี)
 * @property float|null $LAST_CPY_NO ครั้งที่ขอใบแทนหลังสุด (ถ้ามี)
 * @property string|null $LAST_CPY_DATE วันที่ขอใบแทนหลังสุด (ถ้ามี)
 * @property string|null $STOP_USE_DATE วันที่เลิกใช้รถทดสอบ (ถ้ามี)
 * @property string|null $SEND_BACK_DATE วันที่ส่งคืนหนังสืออนุญาต (ถ้ามี)
 * @property string|null $FNC_DATE วันที่ออกใบเสร็จรับเงิน
 * @property string|null $RCP_NO1 เล่มที่ใบเสร็จรับเงินล่าสุด
 * @property string|null $RCP_NO2 เลขที่ใบเสร็จรับเงินล่าสุด
 * @property string|null $PRV_OFF_CODE หน่วยงานออกหนังสืออนุญาตฯ-จังหวัด (หนังสืออนุญาตที่แล้ว)
 * @property string|null $PRV_BR_CODE หน่วยงานออกหนังสืออนุญาตฯ-สาขา (หนังสืออนุญาตที่แล้ว)
 * @property string|null $PRV_CAR_TEST_TYPE ประเภทรถทดสอบ (หนังสืออนุญาตที่แล้ว) T = รถทดสอบก่อนผลิต Q = รถทดสอบคุณภาพ
 * @property string|null $PRV_CERT_YEAR เลขที่หนังสืออนุญาต-ปี พ.ศ. (หนังสืออนุญาตที่แล้ว)
 * @property string|null $PRV_CERT_NO เลขที่หนังสืออนุญาต- อักษร+เลขลำดับ (หนังสืออนุญาตที่แล้ว)
 * @property string|null $UPD_USER_CODE รหัสเจ้าหน้าที่แก้ไขข้อมูลหลังสุด
 * @property string|null $LAST_UPD_DATE วันเวลาแก้ไขข้อมูลหลังสุด
 * @property string|null $CREATE_USER_CODE รหัสเจ้าหน้าที่สร้างข้อมูลครั้งแรก
 * @property string|null $CREATE_DATE วันเวลาสร้างข้อมูลครั้งแรก
 */
class MacTestVehCert extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mac_test_veh_cert';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TEST_VEH_CODE', 'TITLE_CODE', 'ID_NO', 'FNAME', 'LNAME', 'ADDR', 'DIST_CODE', 'AMP_CODE', 'PRV_CODE', 'PHONE', 'NUM_CAR', 'NUM_PLATE', 'INS_CODE', 'INS_NO', 'INS_EXP_DATE', 'FST_PMT_DATE', 'PMT_DATE', 'EXP_DATE', 'CERT_STATUS', 'RENEW_DATE', 'LAST_CPY_NO', 'LAST_CPY_DATE', 'STOP_USE_DATE', 'SEND_BACK_DATE', 'FNC_DATE', 'RCP_NO1', 'RCP_NO2', 'PRV_OFF_CODE', 'PRV_BR_CODE', 'PRV_CAR_TEST_TYPE', 'PRV_CERT_YEAR', 'PRV_CERT_NO', 'UPD_USER_CODE', 'LAST_UPD_DATE', 'CREATE_USER_CODE', 'CREATE_DATE'], 'default', 'value' => null],
            [['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO'], 'required'],
            [['NUM_CAR', 'NUM_PLATE', 'LAST_CPY_NO'], 'number'],
            [['LAST_UPD_DATE', 'CREATE_DATE'], 'safe'],
            [['OFF_CODE', 'TITLE_CODE', 'PRV_CODE', 'PRV_OFF_CODE'], 'string', 'max' => 3],
            [['BR_CODE', 'TEST_VEH_CODE', 'DIST_CODE', 'AMP_CODE', 'PRV_BR_CODE'], 'string', 'max' => 2],
            [['CAR_TEST_TYPE', 'CERT_STATUS', 'PRV_CAR_TEST_TYPE'], 'string', 'max' => 1],
            [['CERT_YEAR', 'INS_CODE', 'PRV_CERT_YEAR'], 'string', 'max' => 4],
            [['CERT_NO', 'PRV_CERT_NO'], 'string', 'max' => 5],
            [['ID_NO'], 'string', 'max' => 13],
            [['FNAME', 'LNAME', 'INS_NO'], 'string', 'max' => 30],
            [['ADDR'], 'string', 'max' => 150],
            [['PHONE'], 'string', 'max' => 10],
            [['INS_EXP_DATE', 'FST_PMT_DATE', 'PMT_DATE', 'EXP_DATE', 'RENEW_DATE', 'LAST_CPY_DATE', 'STOP_USE_DATE', 'SEND_BACK_DATE', 'FNC_DATE'], 'string', 'max' => 8],
            [['RCP_NO1'], 'string', 'max' => 7],
            [['RCP_NO2'], 'string', 'max' => 11],
            [['UPD_USER_CODE', 'CREATE_USER_CODE'], 'string', 'max' => 9],
            [['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO'], 'unique', 'targetAttribute' => ['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OFF_CODE' => 'Off Code',
            'BR_CODE' => 'Br Code',
            'CAR_TEST_TYPE' => 'Car Test Type',
            'CERT_YEAR' => 'Cert Year',
            'CERT_NO' => 'Cert No',
            'TEST_VEH_CODE' => 'Test Veh Code',
            'TITLE_CODE' => 'Title Code',
            'ID_NO' => 'Id No',
            'FNAME' => 'Fname',
            'LNAME' => 'Lname',
            'ADDR' => 'Addr',
            'DIST_CODE' => 'Dist Code',
            'AMP_CODE' => 'Amp Code',
            'PRV_CODE' => 'Prv Code',
            'PHONE' => 'Phone',
            'NUM_CAR' => 'Num Car',
            'NUM_PLATE' => 'Num Plate',
            'INS_CODE' => 'Ins Code',
            'INS_NO' => 'Ins No',
            'INS_EXP_DATE' => 'Ins Exp Date',
            'FST_PMT_DATE' => 'Fst Pmt Date',
            'PMT_DATE' => 'Pmt Date',
            'EXP_DATE' => 'Exp Date',
            'CERT_STATUS' => 'Cert Status',
            'RENEW_DATE' => 'Renew Date',
            'LAST_CPY_NO' => 'Last Cpy No',
            'LAST_CPY_DATE' => 'Last Cpy Date',
            'STOP_USE_DATE' => 'Stop Use Date',
            'SEND_BACK_DATE' => 'Send Back Date',
            'FNC_DATE' => 'Fnc Date',
            'RCP_NO1' => 'Rcp No1',
            'RCP_NO2' => 'Rcp No2',
            'PRV_OFF_CODE' => 'Prv Off Code',
            'PRV_BR_CODE' => 'Prv Br Code',
            'PRV_CAR_TEST_TYPE' => 'Prv Car Test Type',
            'PRV_CERT_YEAR' => 'Prv Cert Year',
            'PRV_CERT_NO' => 'Prv Cert No',
            'UPD_USER_CODE' => 'Upd User Code',
            'LAST_UPD_DATE' => 'Last Upd Date',
            'CREATE_USER_CODE' => 'Create User Code',
            'CREATE_DATE' => 'Create Date',
        ];
    }

    public function getOffice()
    {
        return $this->hasOne(TabOffice::className(), ['OFF_CODE' => 'OFF_CODE']);
    }
    public function getOfficeBranch()
    {
        return $this->hasOne(TabOfficeBr::className(), ['OFF_CODE' => 'OFF_CODE', 'BR_CODE' => 'BR_CODE']);
    }
    public function getTestVehCode()
    {
        return $this->hasOne(MacReqTestVehUser::className(), ['REQ_TEST_VEH_CODE' => 'TEST_VEH_CODE']);
    }

    public function getTitle()
    {
        return $this->hasOne(TabTitle::className(), ['TITLE_CODE' => 'TITLE_CODE']);
    }
    public function getFullname()
    {
        return $this->title->TITLE_DESC . ' ' . $this->FNAME . '  ' . $this->LNAME;
    }

    public function getProvince()
    {
        return $this->hasOne(TabProvince::className(), ['PRV_CODE' => 'PRV_CODE']);
    }
    public function getAmphur()
    {
        return $this->hasOne(TabAmphur::className(), ['PRV_CODE' => 'PRV_CODE', 'AMP_CODE' => 'AMP_CODE']);
    }
    public function getDistrict()
    {
        return $this->hasOne(TabDistrict::className(), ['PRV_CODE' => 'PRV_CODE', 'AMP_CODE' => 'AMP_CODE', 'DIST_CODE' => 'DIST_CODE']);
    }

    // public function getFullAddress(){
    //     return $this->ADDR .' ตำบล/แขวง '. $this->district->DIST_DESC .' อำเภอ/เขต '.$this->amphur->AMP_DESC.' จังหวัด '.$this->province->PRV_DESC;
    // }
    public function getFullAddress()
    {
        if ($this->province->PRV_DESC == 'กรุงเทพมหานคร') {
            $tb = 'แขวง';
        } else {
            $tb = 'ตำบล';
        }
        return $this->ADDR . ' ' . $tb . $this->district->DIST_DESC . ' ' . str_replace("อ.", "อำเภอ", $this->amphur->AMP_DESC) . ' จังหวัด' . $this->province->PRV_DESC;
    }
    public function getIns()
    {
        return $this->hasOne(TabInsurance::className(), ['INS_CODE' => 'INS_CODE']);
    }

    public function validateINS()
    {
        if (strtotime($this->INS_EXP_DATE) <= strtotime($this->EXP_DATE)) {
            $this->addError('INS_EXP_DATE', 'ระยะเวลาการเอาประกันไม่ครอบคลุม ระยะเวลาที่ใช้รถทดสอบ');
            // $this->addError('END_DTE', 'วันที่ไม่ถูกต้อง ควรมากกว่าวันเริ่มต้น');
        }
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

    public function getCertNo()
    {
        return $this->CAR_TEST_TYPE . 'C ' . (int)$this->CERT_NO . "/" . $this->CERT_YEAR;
    }
    public static function getMonth($month)
    {
        switch ($month) {
            case '01':
                return 'มกราคม';
            case '02':
                return 'กุมภาพันธ์ ';
            case '03':
                return 'มีนาคม ';
            case '04':
                return 'เมษายน ';
            case '05':
                return 'พฤษภาคม ';
            case '06':
                return 'มิถุนายน. ';
            case '07':
                return 'กรกฎาคม ';
            case '08':
                return 'สิงหาคม ';
            case '09':
                return 'กันยายน ';
            case '10':
                return 'ตุลาคม ';
            case '11':
                return 'พฤศจิกายน ';
            case '12':
                return 'ธันวาคม ';
        }
        return NULL;
    }

    public function getReportDates()
    {
        $result = Yii::$app->LicenseReportCalculator->calculateReportDates(
            \app\models\MyDate::getDateThai(@$this->PMT_DATE), 
            \app\models\MyDate::getDateThai(@$this->EXP_DATE)
        );

        $output = "ช่วงวันที่ {$result['startDate']} - {$result['endDate']} | ";
        $output .= "ระยะเวลา {$result['totalDays']} วัน<br>";

        $output .= "<strong>วันที่ต้องรายงาน:</strong><br><ul>";
        foreach ($result['reportDates'] as $index => $date) {
            $output .= "<li>" . ($index + 1) . ". วันที่ $date</li>";
        }
        $output .= "</ul>";

        return $output;
    }
}
