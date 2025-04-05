<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_district".
 *
 * @property string $PRV_CODE
 * @property string $AMP_CODE
 * @property string $DIST_CODE
 * @property string $DIST_DESC
 * @property string $DIST_ENG_DESC
 * @property string $UPD_USER_CODE
 * @property string $LAST_UPD_DATE
 * @property string $CREATE_USER_CODE
 * @property string $CREATE_DATE
 * @property string $ZIP_CODE
 * @property string $CANC_FLAG
 */
class TabDistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function getDb(){
        return Yii::$app->get('db2');
    }
    public static function tableName()
    {
        return 'TAB_DISTRICT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRV_CODE', 'AMP_CODE', 'DIST_CODE'], 'required'],
            [['LAST_UPD_DATE', 'CREATE_DATE'], 'safe'],
            [['PRV_CODE'], 'string', 'max' => 3],
            [['AMP_CODE', 'DIST_CODE'], 'string', 'max' => 2],
            [['DIST_DESC', 'DIST_ENG_DESC'], 'string', 'max' => 25],
            [['UPD_USER_CODE', 'CREATE_USER_CODE'], 'string', 'max' => 9],
            [['ZIP_CODE'], 'string', 'max' => 15],
            [['CANC_FLAG'], 'string', 'max' => 1],
            [['PRV_CODE', 'AMP_CODE', 'DIST_CODE'], 'unique', 'targetAttribute' => ['PRV_CODE', 'AMP_CODE', 'DIST_CODE'], 'message' => 'The combination of รหัสจังหวัด, รหัสอำเภอ and รหัสตำบล has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRV_CODE' => 'รหัสจังหวัด',
            'AMP_CODE' => 'รหัสอำเภอ',
            'DIST_CODE' => 'รหัสตำบล',
            'DIST_DESC' => 'ชื่อตำบล',
            'DIST_ENG_DESC' => 'ชื่อตำบลภาษาอังกฤษ',
            'UPD_USER_CODE' => 'รหัสผู้ปรับปรุงข้อมูล',
            'LAST_UPD_DATE' => 'วันที่ปรับปรุงข้อมูล',
            'CREATE_USER_CODE' => 'รหัสผู้สร้างข้อมูล',
            'CREATE_DATE' => 'วันที่สร้างข้อมูล',
            'ZIP_CODE' => 'รหัสไปรษณีย์',
            'CANC_FLAG' => 'สถานะรหัส (\'U\'=ใช้งาน, \'C\'=ยกเลิก)',
        ];
    }
}
