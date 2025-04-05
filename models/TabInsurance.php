<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_insurance".
 *
 * @property string $INS_CODE
 * @property string $INS_NAME
 * @property string $INTER_FLAG
 * @property string $UPD_USER_CODE
 * @property string $LAST_UPD_DATE
 * @property string $CREATE_USER_CODE
 * @property string $CREATE_DATE
 * @property string $INS_ABBR_NAME
 */
class TabInsurance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TAB_INSURANCE';
    }
    public static function getDb(){
        return Yii::$app->get('db2');
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['INS_CODE'], 'required'],
            [['LAST_UPD_DATE', 'CREATE_DATE'], 'safe'],
            [['INS_CODE'], 'string', 'max' => 4],
            [['INS_NAME'], 'string', 'max' => 60],
            [['INTER_FLAG'], 'string', 'max' => 1],
            [['UPD_USER_CODE', 'CREATE_USER_CODE'], 'string', 'max' => 9],
            [['INS_ABBR_NAME'], 'string', 'max' => 5],
            [['INS_CODE'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'INS_CODE' => 'รหัสบริษัทประกัน',
            'INS_NAME' => 'ชื่อบริษัทประกัน',
            'INTER_FLAG' => 'flag การขายผ่าน internet กรม \"0\"= ไม่ขาย ,\"1\" = ขาย',
            'UPD_USER_CODE' => 'รหัสผู้ปรับปรุงข้อมูล',
            'LAST_UPD_DATE' => 'วันที่ปรับปรุงข้อมูล',
            'CREATE_USER_CODE' => 'รหัสผู้สร้างข้อมูล',
            'CREATE_DATE' => 'วันที่สร้างข้อมูล',
            'INS_ABBR_NAME' => 'ชื่อย่อบริษัทประกัน',
        ];
    }
}
