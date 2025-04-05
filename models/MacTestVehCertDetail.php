<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mac_test_veh_cert_detail".
 *
 * @property string $OFF_CODE หน่วยงานออกหนังสืออนุญาตฯ-จังหวัด
 * @property string $BR_CODE หน่วยงานออกหนังสืออนุญาตฯ-สาขา
 * @property string $CAR_TEST_TYPE ประเภทรถทดสอบ  T = รถทดสอบก่อนผลิต   Q = รถทดสอบคุณภาพ
 * @property string $CERT_YEAR เลขที่หนังสืออนุญาต-ปี พ.ศ.
 * @property string $CERT_NO เลขที่หนังสืออนุญาต- อักษร+เลขลำดับ
 * @property string $CAR_TYPE ประเภทรถ  1 = รถยนต์  2 = รถจักรยานยนต์
 * @property string $PLATE1 เลขที่เครื่องหมายฯ หมวดอักษร
 * @property string $PLATE2 เลขที่เครื่องหมายฯ (อักษร+เลขลำดับ)
 * @property float|null $PLATE_SEQ ลำดับรายการ
 * @property string|null $NUM_BODY หมายเลขตัวรถ
 * @property string|null $ENG_FLAG flag M= เครื่องยนต์   E= มอเตอร์ไฟฟ้า
 * @property string|null $NUM_ENG หมายเลขเครื่องยนต์
 * @property string|null $SERIES_NAME ชื่อรุ่นรถ เช่น city,soluna
 * @property string|null $TEST_DATE วันที่ใช้ทดสอบ
 * @property int|null $TEST_DISTANCE ระยะทางที่ใช้ทดสอบ (กิโลเมตร)
 * @property int|null $TEST_TIME เวลาที่ใช้ทดสอบ (ชั่วโมง)
 * @property string|null $RENEW_DATE วันที่ต่ออายุ (ถ้ามี)
 * @property float|null $LAST_CPY_NO ครั้งที่ขอใบแทนหลังสุด (ถ้ามี)
 * @property string|null $LAST_CPY_DATE วันที่ขอใบแทนหลังสุด (ถ้ามี)
 * @property string|null $SEND_BACK_DATE วันที่ส่งคืนเครื่องหมายฯ (ถ้ามี)
 * @property string|null $STOP_USE_DATE วันที่แจ้งยกเลิก
 * @property string|null $SEND_BACK_FLAG สถานะการส่งคืนเครื่องหมายฯ N = ยังไม่ได้ส่งคืน Y = ส่งคืนแล้ว
 * @property string|null $VEH_STATUS สถานะรถ
 * @property string|null $UPD_USER_CODE รหัสเจ้าหน้าที่แก้ไขข้อมูลหลังสุด
 * @property string|null $LAST_UPD_DATE วันเวลาแก้ไขข้อมูลหลังสุด
 * @property string|null $CREATE_USER_CODE รหัสเจ้าหน้าที่สร้างข้อมูลครั้งแรก
 * @property string|null $CREATE_DATE วันเวลาสร้างข้อมูลครั้งแรก
 */
class MacTestVehCertDetail extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mac_test_veh_cert_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PLATE_SEQ', 'NUM_BODY', 'ENG_FLAG', 'NUM_ENG', 'SERIES_NAME', 'TEST_DATE', 'TEST_DISTANCE', 'TEST_TIME', 'RENEW_DATE', 'LAST_CPY_NO', 'LAST_CPY_DATE', 'SEND_BACK_DATE', 'STOP_USE_DATE', 'SEND_BACK_FLAG', 'UPD_USER_CODE', 'LAST_UPD_DATE', 'CREATE_USER_CODE', 'CREATE_DATE'], 'default', 'value' => null],
            [['VEH_STATUS'], 'default', 'value' => 'A'],
            [['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO', 'CAR_TYPE', 'PLATE1', 'PLATE2'], 'required'],
            [['PLATE_SEQ', 'LAST_CPY_NO'], 'number'],
            [['TEST_DISTANCE', 'TEST_TIME'], 'integer'],
            [['LAST_UPD_DATE', 'CREATE_DATE'], 'safe'],
            [['OFF_CODE'], 'string', 'max' => 3],
            [['BR_CODE'], 'string', 'max' => 2],
            [['CAR_TEST_TYPE', 'CAR_TYPE', 'ENG_FLAG', 'SEND_BACK_FLAG', 'VEH_STATUS'], 'string', 'max' => 1],
            [['CERT_YEAR'], 'string', 'max' => 4],
            [['CERT_NO', 'PLATE1', 'PLATE2'], 'string', 'max' => 5],
            [['NUM_BODY', 'NUM_ENG', 'SERIES_NAME'], 'string', 'max' => 30],
            [['TEST_DATE', 'RENEW_DATE', 'LAST_CPY_DATE', 'SEND_BACK_DATE', 'STOP_USE_DATE'], 'string', 'max' => 8],
            [['UPD_USER_CODE', 'CREATE_USER_CODE'], 'string', 'max' => 9],
            [['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO', 'CAR_TYPE', 'PLATE1', 'PLATE2'], 'unique', 'targetAttribute' => ['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO', 'CAR_TYPE', 'PLATE1', 'PLATE2']],
        ];
    }

    /**
     * {@inheritdoc}
     */
     public function attributeLabels()
    {
        return [
            'OFF_CODE' => 'หน่วยงานออกหนังสืออนุญาตฯ-จังหวัด',
            'BR_CODE' => 'หน่วยงานออกหนังสืออนุญาตฯ-สาขา',
            'CAR_TEST_TYPE' => 'T/Q',
            'CERT_YEAR' => 'ปี พ.ศ.',
            'CERT_NO' => 'เลขที่หนังสืออนุญาต',
            'CAR_TYPE' => ' รถยนต์/รถจักรยานยนต์',
            'PLATE1' => 'เลขที่เครื่องหมายฯ หมวดอักษร',
            'PLATE2' => 'เลขที่เครื่องหมายฯ (อักษร+เลขลำดับ)',
            'PLATE_SEQ' => 'ลำดับรายการ',
            'NUM_BODY' => 'หมายเลขตัวรถ',
            'NUM_ENG' => 'หมายเลขเครื่องยนต์',
            'ENG_FLAG'=>'flag M= เครื่องยนต์   E= มอเตอร์ไฟฟ้า',
            'TEST_DATE' => 'วันที่ใช้ทดสอบ',
            'TEST_DISTANCE' => 'ระยะทางที่ใช้ทดสอบ (กิโลเมตร)',
            'TEST_TIME' => 'เวลาที่ใช้ทดสอบ (ชั่วโมง)',
            'RENEW_DATE' => 'วันที่ต่ออายุ (ถ้ามี)',
            'VEH_FLAG' => 'สถานะรถทดสอบ',
            'STOP_USE_DATE' => 'วันที่ยกเลิกใช้รถทดสอบ',
            'LAST_CPY_NO' => 'ครั้งที่ขอใบแทนหลังสุด (ถ้ามี)',
            'LAST_CPY_DATE' => 'วันที่ขอใบแทนหลังสุด (ถ้ามี)',
            'SEND_BACK_DATE' => 'วันที่ส่งคืนเครื่องหมายฯ (ถ้ามี)',
            'SEND_BACK_FLAG' => 'สถานะการส่งคืนเครื่องหมายฯ N = ยังไม่ได้ส่งคืน Y = ส่งคืนแล้ว',
            'UPD_USER_CODE' => 'รหัสเจ้าหน้าที่แก้ไขข้อมูลหลังสุด',
            'LAST_UPD_DATE' => 'วันเวลาแก้ไขข้อมูลหลังสุด',
            'CREATE_USER_CODE' => 'รหัสเจ้าหน้าที่สร้างข้อมูลครั้งแรก',
            'CREATE_DATE' => 'วันเวลาสร้างข้อมูลครั้งแรก',
            'SERIES_NAME'=>'รุ่นรถ',
            'IS_REPORT'=> 'รายงานการใช้เครื่องหมาย'
        ];
    }

public function getReportFlag() {
        switch ($this->IS_REPORT) {
            case 'Y':
                return '<i class="fa fa-circle" aria-hidden="true" style="color: #00bb00"></i> บันทึกข้อมูลแล้ว';
            case Null:
                return '<i class="fa fa-circle" aria-hidden="true" style="color: #521607FF"></i> ยังไม่บันทึกข้อมูล ';
        }
        return NULL;
}
public function getCarTestType() {
        switch ($this->CAR_TEST_TYPE) {
            case 'T':
                return 'รถทดสอบก่อนผลิต ';
            case 'Q':
                return 'รถทดสอบคุณภาพ. ';
        }
        return NULL;
    }

    public function getEngFlag() {
        switch ($this->ENG_FLAG) {
            case 'E':
                return 'มอเตอร์ไฟฟ้า ';
        }
        return NULL;
    }
    public function getNUM_ENGS() {
        switch ($this->ENG_FLAG) {
            case 'E':
                return $this->NUM_ENG. ' (มอเตอร์ไฟฟ้า)';
        }
        return $this->NUM_ENG;
    }

    public function getSendBackFlag() {
        switch ($this->SEND_BACK_FLAG) {
            case 'Y':
                return 'ส่งคืนแล้ว';
            case 'N':
                return 'ยังไม่ได้ส่งคืน ';
        }
        return NULL;
    }
    public function getCarTestType2() {
        switch ($this->CAR_TEST_TYPE) {
            case 'T':
                return 'TC ';
            case 'Q':
                return 'QC. ';
        }
        return NULL;
    }

    public function getCarType() {
        switch ($this->CAR_TYPE) {
            case 1:
                return 'รถยนต์ ';
            case 2:
                return 'รถจักรยานยนต์';
        }
        return NULL;
    }
    public function getMacTestVehCert(){
        return $this->hasOne(MacTestVehCert::className(),['OFF_CODE' =>'OFF_CODE', 'BR_CODE' => 'BR_CODE', 'CAR_TEST_TYPE' => 'CAR_TEST_TYPE', 'CERT_YEAR' =>'CERT_YEAR', 'CERT_NO' => 'CERT_NO']);
    }
    public function getPlate(){
       // return $this->PLATE1.' '.(int)$this->PLATE2.''.$this->VEH_STATUS == 'C' ? '<p class="label label-danger">เลิกใช้</p>' : '';
        return $this->VEH_STATUS == 'C' ? $this->PLATE1.' '.(int)$this->PLATE2 : $this->PLATE1.' '.(int)$this->PLATE2;
    }
        public function getPlateCancel(){
       // return $this->PLATE1.' '.(int)$this->PLATE2.''.$this->VEH_STATUS == 'C' ? '<p class="label label-danger">เลิกใช้</p>' : '';
        return $this->VEH_STATUS == 'C' ? 'ยกเลิก' :'ปกติ';
    }

    public function getCertNo(){
        return $this->CAR_TEST_TYPE.'C' .(int)$this->CERT_NO. "/" .$this->CERT_YEAR;
    }

    public function CreateAT($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO,$CAR_TYPE, $PLATE1, $PLATE2){
        $names = Yii::$app->db->createCommand("SELECT  to_char(CREATE_DATE, 'yyyy-mm-dd hh24:mi:ss') CREATE_AT FROM DLT.MAC_TEST_VEH_CERT_DETAIL WHERE OFF_CODE ='$OFF_CODE' AND BR_CODE = '$BR_CODE' AND CAR_TEST_TYPE= '$CAR_TEST_TYPE' AND CERT_YEAR = '$CERT_YEAR' AND CERT_NO='$CERT_NO'AND CAR_TYPE = '$CAR_TYPE' AND PLATE1= '$PLATE1' AND PLATE2 = '$PLATE2' ")->queryOne();
        $tmp = '';
        foreach($names as $v) {
            $tmp .= $names['CREATE_AT'];
        }
        return $tmp;
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
}
