<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_amphur".
 *
 * @property string $PRV_CODE
 * @property string $AMP_CODE
 * @property string $AMP_DESC
 * @property string $AMP_ENG_DESC
 * @property string $RESP_BR_CODE
 * @property string $UPD_USER_CODE
 * @property string $LAST_UPD_DATE
 * @property string $CREATE_USER_CODE
 * @property string $CREATE_DATE
 * @property string $CANC_FLAG
 *
 * @property TabProvince $pRVCODE
 * @property TabProvince $pRVCODE0
 * @property TabProvince $pRVCODE1
 */
class TabAmphur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function getDb(){
        return Yii::$app->get('db2');
    }
    public static function tableName()
    {
        return 'TAB_AMPHUR';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRV_CODE', 'AMP_CODE'], 'required'],
            [['LAST_UPD_DATE', 'CREATE_DATE'], 'safe'],
            [['PRV_CODE'], 'string', 'max' => 3],
            [['AMP_CODE', 'RESP_BR_CODE'], 'string', 'max' => 2],
            [['AMP_DESC', 'AMP_ENG_DESC'], 'string', 'max' => 25],
            [['UPD_USER_CODE', 'CREATE_USER_CODE'], 'string', 'max' => 9],
            [['CANC_FLAG'], 'string', 'max' => 1],
            [['PRV_CODE'], 'exist', 'skipOnError' => true, 'targetClass' => TabProvince::className(), 'targetAttribute' => ['PRV_CODE' => 'PRV_CODE']],
            [['PRV_CODE'], 'exist', 'skipOnError' => true, 'targetClass' => TabProvince::className(), 'targetAttribute' => ['PRV_CODE' => 'PRV_CODE']],
            [['PRV_CODE'], 'exist', 'skipOnError' => true, 'targetClass' => TabProvince::className(), 'targetAttribute' => ['PRV_CODE' => 'PRV_CODE']],
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
            'AMP_DESC' => 'ชื่ออำเภอ',
            'AMP_ENG_DESC' => 'ชื่ออำเภอภาษาอังกฤษ',
            'RESP_BR_CODE' => 'รหัสสำนักงานพื้นที่รับผิดชอบ',
            'UPD_USER_CODE' => 'รหัสผู้ปรับปรุงข้อมูล',
            'LAST_UPD_DATE' => 'วันที่ปรับปรุงข้อมูล',
            'CREATE_USER_CODE' => 'รหัสผู้สร้างข้อมูล',
            'CREATE_DATE' => 'วันที่สร้างข้อมูล',
            'CANC_FLAG' => 'สถานะรหัส (\'U\'=ใช้งาน, \'C\'=ยกเลิก)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPRVCODE()
    {
        return $this->hasOne(TabProvince::className(), ['PRV_CODE' => 'PRV_CODE']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPRVCODE0()
    {
        return $this->hasOne(TabProvince::className(), ['PRV_CODE' => 'PRV_CODE']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPRVCODE1()
    {
        return $this->hasOne(TabProvince::className(), ['PRV_CODE' => 'PRV_CODE']);
    }
}
