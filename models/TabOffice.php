<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab_office".
 *
 * @property string $OFF_CODE
 * @property string $REGION_CODE
 * @property string $OFF_DESC
 * @property string $OFF_ENG_DESC
 * @property string $BUD_OFF_CODE
 * @property string $ZIP_CODE
 * @property string $UPD_USER_CODE
 * @property string $LAST_UPD_DATE
 * @property string $CREATE_USER_CODE
 * @property string $CREATE_DATE
 * @property string $PRV_CODE
 * @property string $AMP_CODE
 * @property string $ACC_KHET_CODE
 * @property string $SAL_BANK
 * @property string $NB_BANK_CODE
 * @property string $NB_BANKBR_CODE
 * @property string $NB_BANK_ACCT_NO
 * @property string $FNC_DOC_DEPT_CODE
 * @property string $BOR_FLAG
 * @property string $ACT_USE_FLAG
 * @property string $SOC_ACCT_NO
 * @property string $ACC_REG_CODE
 * @property string $LOCAL_ACC_KHET_CODE
 * @property string $OLD_REGION_CODE
 * @property string $OFF_LEV9_FLAG
 */
class TabOffice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TAB_OFFICE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OFF_CODE', 'OFF_DESC'], 'required'],
            [['LAST_UPD_DATE', 'CREATE_DATE'], 'safe'],
            [['OFF_CODE', 'PRV_CODE', 'NB_BANKBR_CODE'], 'string', 'max' => 3],
            [['REGION_CODE', 'BOR_FLAG', 'ACT_USE_FLAG', 'ACC_REG_CODE', 'OLD_REGION_CODE', 'OFF_LEV9_FLAG'], 'string', 'max' => 1],
            [['OFF_DESC', 'NB_BANK_ACCT_NO'], 'string', 'max' => 20],
            [['OFF_ENG_DESC'], 'string', 'max' => 60],
            [['BUD_OFF_CODE'], 'string', 'max' => 6],
            [['ZIP_CODE'], 'string', 'max' => 5],
            [['UPD_USER_CODE', 'CREATE_USER_CODE'], 'string', 'max' => 9],
            [['AMP_CODE', 'NB_BANK_CODE'], 'string', 'max' => 2],
            [['ACC_KHET_CODE', 'LOCAL_ACC_KHET_CODE'], 'string', 'max' => 10],
            [['SAL_BANK'], 'string', 'max' => 100],
            [['FNC_DOC_DEPT_CODE'], 'string', 'max' => 30],
            [['SOC_ACCT_NO'], 'string', 'max' => 15],
            [['OFF_CODE'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'OFF_CODE' => '????????????????????????',
            'REGION_CODE' => '???????',
            'OFF_DESC' => '????????????????????????',
            'OFF_ENG_DESC' => '??????????????????????????????????????',
            'BUD_OFF_CODE' => '?????????????????????????????',
            'ZIP_CODE' => '????????????',
            'UPD_USER_CODE' => '?????????????????????',
            'LAST_UPD_DATE' => '????????????????????',
            'CREATE_USER_CODE' => '??????????????????',
            'CREATE_DATE' => '?????????????????',
            'PRV_CODE' => 'Prv  Code',
            'AMP_CODE' => 'Amp  Code',
            'ACC_KHET_CODE' => 'Acc  Khet  Code',
            'SAL_BANK' => 'Sal  Bank',
            'NB_BANK_CODE' => 'Nb  Bank  Code',
            'NB_BANKBR_CODE' => 'Nb  Bankbr  Code',
            'NB_BANK_ACCT_NO' => 'Nb  Bank  Acct  No',
            'FNC_DOC_DEPT_CODE' => 'รหัสหน่วยงานหน้าเอกสารการเงิน',
            'BOR_FLAG' => 'Bor  Flag',
            'ACT_USE_FLAG' => 'flag เริ่มใช้ระบบบัญชีจังหวัด',
            'SOC_ACCT_NO' => 'เลขที่บัญชีประกันสังคม',
            'ACC_REG_CODE' => 'เขตรับผิดชอบของกรมบัญชีกลาง',
            'LOCAL_ACC_KHET_CODE' => 'รหัสหน่วยเบิกจ่ายของ อบจ.',
            'OLD_REGION_CODE' => 'Old  Region  Code',
            'OFF_LEV9_FLAG' => 'Off  Lev9  Flag',
        ];
    }
}
