<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mac_test_veh_cert_detail_report".
 *
 * @property string $OFF_CODE หน่วยงานออกหนังสืออนุญาตฯ-จังหวัด
 * @property string $BR_CODE หน่วยงานออกหนังสืออนุญาตฯ-สาขา
 * @property string $CAR_TEST_TYPE ประเภทรถทดสอบ  T = รถทดสอบก่อนผลิต   Q = รถทดสอบคุณภาพ
 * @property string $CERT_YEAR เลขที่หนังสืออนุญาต-ปี พ.ศ.
 * @property string $CERT_NO เลขที่หนังสืออนุญาต- อักษร+เลขลำดับ
 * @property string $CAR_TYPE ประเภทรถ  1 = รถยนต์  2 = รถจักรยานยนต์
 * @property string $PLATE1 เลขที่เครื่องหมายฯ หมวดอักษร
 * @property string $PLATE2 เลขที่เครื่องหมายฯ (อักษร+เลขลำดับ)
 * @property string|null $NUM_BODY หมายเลขตัวรถ
 * @property string|null $ENG_FLAG flag M= เครื่องยนต์   E= มอเตอร์ไฟฟ้า
 * @property string|null $NUM_ENG หมายเลขเครื่องยนต์
 * @property string|null $SERIES_NAME ชื่อรุ่นรถ เช่น city,soluna
 * @property string|null $TEST_DATE วันที่ใช้ทดสอบ
 * @property int|null $TEST_DISTANCE ระยะทางที่ใช้ทดสอบ (กิโลเมตร)
 * @property int|null $TEST_TIME เวลาที่ใช้ทดสอบ (ชั่วโมง)
 * @property string|null $IS_REPORT บันทึกข้อมูลการทดสอบ
 * @property string|null $REPORT_DATE วันที่รายงานข้อมูล
 * @property string|null $UPD_USER_CODE รหัสเจ้าหน้าที่แก้ไขข้อมูลหลังสุด
 * @property string|null $LAST_UPD_DATE วันเวลาแก้ไขข้อมูลหลังสุด
 * @property string|null $CREATE_USER_CODE รหัสเจ้าหน้าที่สร้างข้อมูลครั้งแรก
 * @property string|null $CREATE_DATE วันเวลาสร้างข้อมูลครั้งแรก
 */
class MacTestVehCertDetailReport extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mac_test_veh_cert_detail_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NUM_BODY', 'ENG_FLAG', 'NUM_ENG', 'SERIES_NAME', 'TEST_DATE', 'TEST_DISTANCE', 'TEST_TIME', 'IS_REPORT', 'REPORT_DATE', 'UPD_USER_CODE', 'LAST_UPD_DATE', 'CREATE_USER_CODE', 'CREATE_DATE'], 'default', 'value' => null],
            [['OFF_CODE', 'BR_CODE', 'CAR_TEST_TYPE', 'CERT_YEAR', 'CERT_NO', 'CAR_TYPE', 'PLATE1', 'PLATE2'], 'required'],
            [['TEST_DISTANCE', 'TEST_TIME'], 'integer'],
            [['REPORT_DATE', 'LAST_UPD_DATE', 'CREATE_DATE'], 'safe'],
            [['OFF_CODE'], 'string', 'max' => 3],
            [['BR_CODE'], 'string', 'max' => 2],
            [['CAR_TEST_TYPE', 'CAR_TYPE', 'ENG_FLAG', 'IS_REPORT'], 'string', 'max' => 1],
            [['CERT_YEAR'], 'string', 'max' => 4],
            [['CERT_NO', 'PLATE1', 'PLATE2'], 'string', 'max' => 5],
            [['NUM_BODY', 'NUM_ENG', 'SERIES_NAME'], 'string', 'max' => 30],
            [['TEST_DATE'], 'string', 'max' => 8],
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
            'OFF_CODE' => 'Off Code',
            'BR_CODE' => 'Br Code',
            'CAR_TEST_TYPE' => 'Car Test Type',
            'CERT_YEAR' => 'Cert Year',
            'CERT_NO' => 'Cert No',
            'CAR_TYPE' => 'Car Type',
            'PLATE1' => 'Plate1',
            'PLATE2' => 'Plate2',
            'NUM_BODY' => 'Num Body',
            'ENG_FLAG' => 'Eng Flag',
            'NUM_ENG' => 'Num Eng',
            'SERIES_NAME' => 'Series Name',
            'TEST_DATE' => 'Test Date',
            'TEST_DISTANCE' => 'Test Distance',
            'TEST_TIME' => 'Test Time',
            'IS_REPORT' => 'Is Report',
            'REPORT_DATE' => 'Report Date',
            'UPD_USER_CODE' => 'Upd User Code',
            'LAST_UPD_DATE' => 'Last Upd Date',
            'CREATE_USER_CODE' => 'Create User Code',
            'CREATE_DATE' => 'Create Date',
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
         return  $this->PLATE1.' '.(int)$this->PLATE2;
     }
    public function getCertNo(){
        return $this->CAR_TEST_TYPE.'C' .(int)$this->CERT_NO. "/" .$this->CERT_YEAR;
    }

}
