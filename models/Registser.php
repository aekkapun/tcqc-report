<?php

namespace app\models;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Uploads;
use app\models\Member;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "registser".
 *
 * @property int $id
 * @property string|null $ref
 * @property string $dbd_no
 * @property string|null $dbd_name
 * @property string $dbd_manager
 * @property string|null $user_docno
 * @property string|null $email
 * @property string|null $tel
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $title
 * @property string $fname
 * @property string|null $lname
 * @property string|null $company
 * @property string|null $address
 */
class Registser extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registser';
    }
        public $hasUploadedFiles = false;

        public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_at',
                'updatedAtAttribute' => 'update_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
            public function init()
    {
        parent::init();
        // Generate unique reference for file uploads if new record
        if ($this->isNewRecord) {
            $this->ref = substr(Yii::$app->security->generateRandomString(), 10);
        }
    }

        public function checkUploadedFiles()
    {
        if ($this->ref) {
            $uploadPath = Yii::getAlias('@webroot/uploads/member/' . $this->ref);
            if (is_dir($uploadPath)) {
                $files = \yii\helpers\FileHelper::findFiles($uploadPath);
                return !empty($files);
            }
        }
        return false;
    }

    // Override beforeValidate
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->hasUploadedFiles = $this->checkUploadedFiles();
            return true;
        }
        return false;
    }
    
    public function rules()
    {
        return [
            [['dbd_name', 'user_docno', 'email', 'tel', 'created_at', 'updated_at', 'title', 'lname', 'company', 'address'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 10],
            [['dbd_no', 'dbd_manager', 'fname'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['dbd_no', 'user_docno', 'tel'], 'string', 'max' => 15],
            [['dbd_name', 'email'], 'string', 'max' => 50],
            [['dbd_manager', 'fname', 'lname'], 'string', 'max' => 120],
            [['title'], 'string', 'max' => 1],
            [['company'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 200],
            [['email'], 'unique'],
            [['user_docno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref' => 'Ref',
            'dbd_no' => 'Dbd No',
            'dbd_name' => 'Dbd Name',
            'dbd_manager' => 'Dbd Manager',
            'user_docno' => 'User Docno',
            'email' => 'Email',
            'tel' => 'Tel',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => 'Title',
            'fname' => 'Fname',
            'lname' => 'Lname',
            'company' => 'Company',
            'address' => 'Address',
        ];
    }

}
