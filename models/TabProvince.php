<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_province".
 *
 * @property string $PRV_CODE
 * @property string $PRV_DESC
 * @property string $PRV_ABREV
 * @property string $PRV_ENG_DESC
 * @property string $PRV_ABREV_ENG
 * @property string $UPD_USER_CODE
 * @property string $LAST_UPD_DATE
 * @property string $CREATE_USER_CODE
 * @property string $CREATE_DATE
 * @property string $REGION_CODE
 * @property string $OLD_REGION_CODE
 * @property string $TRS_JOB_CODE
 * @property string $PRV_CODE_INSURE
 */
class TabProvince extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TAB_PROVINCE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PRV_CODE', 'PRV_DESC'], 'required'],
            [['LAST_UPD_DATE', 'CREATE_DATE'], 'safe'],
            [['PRV_CODE', 'PRV_ABREV_ENG'], 'string', 'max' => 3],
            [['PRV_DESC'], 'string', 'max' => 20],
            [['PRV_ABREV', 'PRV_CODE_INSURE'], 'string', 'max' => 2],
            [['PRV_ENG_DESC'], 'string', 'max' => 25],
            [['UPD_USER_CODE', 'CREATE_USER_CODE'], 'string', 'max' => 9],
            [['REGION_CODE', 'OLD_REGION_CODE', 'TRS_JOB_CODE'], 'string', 'max' => 1],
            [['PRV_CODE'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PRV_CODE' => 'รหัสจังหวัด',
            'PRV_DESC' => 'ชื่อจังหวัด',
            'PRV_ABREV' => 'ชื่อย่อจังหวัด',
            'PRV_ENG_DESC' => 'ชื่อจังหวัดภาษาอังกฤษ',
            'PRV_ABREV_ENG' => 'ชื่อย่อจังหวัดภาษาอังกฤษ',
            'UPD_USER_CODE' => 'รหัสผู้ปรับปรุงข้อมูล',
            'LAST_UPD_DATE' => 'วันที่ปรับปรุงข้อมูล',
            'CREATE_USER_CODE' => 'รหัสผู้สร้างข้อมูล',
            'CREATE_DATE' => 'วันที่สร้างข้อมูล',
            'REGION_CODE' => 'Region  Code',
            'OLD_REGION_CODE' => 'Old  Region  Code',
            'TRS_JOB_CODE' => 'Trs  Job  Code',
            'PRV_CODE_INSURE' => 'รหัสจังหวัดของ คปภ.',
        ];
    }
}
