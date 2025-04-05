<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_title".
 *
 * @property string $TITLE_CODE
 * @property string $TITLE_DESC
 * @property string $TITLE_ABREV
 * @property string $TITLE_SEX
 * @property string $TITLE_ENG_DESC
 * @property string $TITLE_ENG_ABREV
 * @property string $TITLE_BLANK_FLAG
 * @property string $UPD_USER_CODE
 * @property string $LAST_UPD_DATE
 * @property string $CREATE_USER_CODE
 * @property string $CREATE_DATE
 * @property string $PRIVATE_FLAG
 * @property string $PRT_FLAG
 * @property string $PERS_TYPE
 */
class TabTitle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'TAB_TITLE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TITLE_CODE', 'TITLE_DESC'], 'required'],
            [['LAST_UPD_DATE', 'CREATE_DATE'], 'safe'],
            [['TITLE_CODE'], 'string', 'max' => 3],
            [['TITLE_DESC', 'TITLE_ABREV', 'TITLE_ENG_DESC', 'TITLE_ENG_ABREV'], 'string', 'max' => 30],
            [['TITLE_SEX', 'TITLE_BLANK_FLAG', 'PRIVATE_FLAG', 'PRT_FLAG', 'PERS_TYPE'], 'string', 'max' => 1],
            [['UPD_USER_CODE', 'CREATE_USER_CODE'], 'string', 'max' => 9],
            [['TITLE_CODE'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TITLE_CODE' => 'รหัสคำนำหน้าชื่อ',
            'TITLE_DESC' => 'ชื่อคำนำหน้าชื่อ',
            'TITLE_ABREV' => 'ชื่อย่อคำนำหน้าชื่อ',
            'TITLE_SEX' => 'เพศ',
            'TITLE_ENG_DESC' => 'คำนำหน้าชื่อภาษาอังกฤษ',
            'TITLE_ENG_ABREV' => 'ชื่อย่อคำนำหน้าชื่อภาษาอังกฤษ',
            'TITLE_BLANK_FLAG' => 'flag ช่องว่าง',
            'UPD_USER_CODE' => 'รหัสผู้ปรับปรุงข้อมูล',
            'LAST_UPD_DATE' => 'วันที่ปรับปรุงข้อมูล',
            'CREATE_USER_CODE' => 'รหัสผู้สร้างข้อมูล',
            'CREATE_DATE' => 'วันที่สร้างข้อมูล',
            'PRIVATE_FLAG' => 'Private  Flag',
            'PRT_FLAG' => 'flag แสดงว่าจะแสดงคำนำหน้าชื่อหรือไม่ (0=ไม่พิมพ์ ,1=พิมพ์)',
            'PERS_TYPE' => 'ประเภทบุคคล (1=บุคคลธรรมดา, 2=นิติบุคคล)',
        ];
    }
}
