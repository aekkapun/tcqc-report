<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_tr".
 *
 * @property string $SYS_CODE
 * @property string $TR_CODE
 * @property string $TR_DESC
 * @property string $UPD_USER_CODE
 * @property string $LAST_UPD_DATE
 * @property string $CREATE_USER_CODE
 * @property string $CREATE_DATE
 */
class TabTr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DLT.TAB_TR';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SYS_CODE', 'TR_CODE', 'TR_DESC'], 'required'],
            [['LAST_UPD_DATE', 'CREATE_DATE'], 'safe'],
            [['SYS_CODE', 'TR_CODE'], 'string', 'max' => 2],
            [['TR_DESC'], 'string', 'max' => 100],
            [['UPD_USER_CODE', 'CREATE_USER_CODE'], 'string', 'max' => 9],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SYS_CODE' => 'รหัสระบบ   
10 = การเงิน ,   
20 = ควบคุมบัญชีรถ เครื่องยนต์ และคัสซี ,   
30 = ตรวจสภาพรถยนต์,   
35 = ทะเบียนรถยนต์ ,   
40 = ตรวจสภาพรถขนส่ง ,   
45 = ทะเบียนรถขนส่ง ,   
50 = ใบอนุญาตขับรถ ,   
60 = ใบอนุญาตผู้ประจำรถ,   
70 = ประกอบการขนส่ง',
            'TR_CODE' => 'รหัสการดำเนินการ',
            'TR_DESC' => 'รายละเอียดการดำเนินการ',
            'UPD_USER_CODE' => 'รหัสผู้ปรับปรุงข้อมูล',
            'LAST_UPD_DATE' => 'วันที่ปรับปรุงข้อมูล',
            'CREATE_USER_CODE' => 'รหัสผู้สร้างข้อมูล',
            'CREATE_DATE' => 'วันที่สร้างข้อมูล',
        ];
    }
}
