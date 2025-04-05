<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use app\models\Uploads;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property int $id
 * @property string $company_registration_number เลขที่ทะเบียนนิติบุคคล
 * @property string $company_name ชื่อบริษัท
 * @property string $ref รหัส
 * @property string $authorized_person กรรมการซึ่งลงชื่อผูกพันบริษัท (ผู้มีอำนาจลงนาม)
 * @property string $proxy_person ผู้รับมอบอำนาจ
 * @property string $email อีเมล์
 * @property string $phone เบอร์โทรศัพท์
 * @property string|null $company_certificate_file หนังสือรับรองการจดทะเบียนนิติบุคคล
 * @property string|null $proxy_file หนังสือมอบอำนาจ
 * @property string|null $authorized_person_id_file สำเนาบัตรประชาชนผู้มีอำนาจลงนาม
 * @property string|null $proxy_person_id_file สำเนาบัตรประชาชนผู้รับมอบอำนาจ
 * @property int $status สถานะการลงทะเบียน
 * @property int $created_at วันที่สร้าง
 * @property int $updated_at วันที่แก้ไข
 *
 * @property License[] $licenses
 * @property MonthlyReport[] $monthlyReports
 * @property User[] $users
 */
class Company extends ActiveRecord
{
    const UPLOAD_FOLDER='peper';
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    
    /**
     * สำหรับเก็บไฟล์อัพโหลด
     */
    public $company_certificate_upload;
    public $proxy_upload;
    public $authorized_person_id_upload;
    public $proxy_person_id_upload;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vt_company}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_registration_number', 'company_name', 'authorized_person', 'proxy_person', 'email', 'phone'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['company_registration_number'], 'string', 'min' => 13, 'max' => 13],
            [['company_registration_number'], 'unique'],
            [['company_name', 'authorized_person', 'proxy_person', 'email', 'company_certificate_file', 'proxy_file', 'authorized_person_id_file', 'proxy_person_id_file'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'email'],
            [['status'], 'default', 'value' => self::STATUS_PENDING],
            [['status'], 'in', 'range' => [self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_REJECTED]],
            [['ref'], 'string', 'max' => 100],
            // กฎสำหรับการอัพโหลดไฟล์
            [['company_certificate_upload', 'proxy_upload', 'authorized_person_id_upload', 'proxy_person_id_upload'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 5], // 5MB
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัส',
            'company_registration_number' => 'เลขที่ทะเบียนนิติบุคคล',
            'company_name' => 'ชื่อบริษัท',
            'authorized_person' => 'กรรมการซึ่งลงชื่อผูกพันบริษัท (ผู้มีอำนาจลงนาม)',
            'proxy_person' => 'ผู้รับมอบอำนาจ',
            'email' => 'อีเมล์',
            'phone' => 'เบอร์โทรศัพท์',
            'company_certificate_file' => 'หนังสือรับรองการจดทะเบียนนิติบุคคล',
            'proxy_file' => 'หนังสือมอบอำนาจ',
            'authorized_person_id_file' => 'สำเนาบัตรประชาชนผู้มีอำนาจลงนาม',
            'proxy_person_id_file' => 'สำเนาบัตรประชาชนผู้รับมอบอำนาจ',
            'status' => 'สถานะ',
            'created_at' => 'วันที่สร้าง',
            'updated_at' => 'วันที่แก้ไข',
            'company_certificate_upload' => 'หนังสือรับรองการจดทะเบียนนิติบุคคล',
            'proxy_upload' => 'หนังสือมอบอำนาจ',
            'authorized_person_id_upload' => 'สำเนาบัตรประชาชนผู้มีอำนาจลงนาม',
            'proxy_person_id_upload' => 'สำเนาบัตรประชาชนผู้รับมอบอำนาจ',
        ];
    }
    public static function getUploadPath(){
        return Yii::getAlias('@webroot').'/'.self::UPLOAD_FOLDER.'/';
    }

    public static function getUploadUrl(){
        return Url::base(true).'/'.self::UPLOAD_FOLDER.'/';
    }
    /**
     * Gets query for [[Licenses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLicenses()
    {
        return $this->hasMany(License::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[MonthlyReports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMonthlyReports()
    {
        return $this->hasMany(MonthlyReport::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['company_id' => 'id']);
    }
    
    /**
     * อัพโหลดไฟล์เอกสาร
     * 
     * @return boolean
     */

     public function getThumbnails($ref,$event_name){
        $uploadFiles   = Uploads::find()->where(['ref'=>$ref])->all();
        $preview = [];
        foreach ($uploadFiles as $file) {
            $preview[] = [
                'url'=>self::getUploadUrl(true).$ref.'/'.$file->real_filename,
                'src'=>self::getUploadUrl(true).$ref.'/thumbnail/'.$file->real_filename,
                'options' => ['title' => $event_name]
            ];
        }
        return $preview;
    }
    public function uploadFiles()
    {
        $uploadPath = Yii::getAlias('@webroot/uploads/company/');
        
        // สร้างโฟลเดอร์สำหรับเก็บไฟล์ถ้ายังไม่มี
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // สร้างชื่อไฟล์ให้ไม่ซ้ำกันโดยใช้ timestamp
        $timestamp = time();
        $hasUploaded = false;
        
        // อัพโหลดไฟล์หนังสือรับรองการจดทะเบียนนิติบุคคล
        if ($this->company_certificate_upload instanceof UploadedFile) {
            $fileName = 'cert_' . $this->company_registration_number . '_' . $timestamp . '.' . $this->company_certificate_upload->extension;
            if ($this->company_certificate_upload->saveAs($uploadPath . $fileName)) {
                $this->company_certificate_file = $fileName;
                $hasUploaded = true;
            }
        }
        
        // อัพโหลดไฟล์หนังสือมอบอำนาจ
        if ($this->proxy_upload instanceof UploadedFile) {
            $fileName = 'proxy_' . $this->company_registration_number . '_' . $timestamp . '.' . $this->proxy_upload->extension;
            if ($this->proxy_upload->saveAs($uploadPath . $fileName)) {
                $this->proxy_file = $fileName;
                $hasUploaded = true;
            }
        }
        
        // อัพโหลดไฟล์สำเนาบัตรประชาชนผู้มีอำนาจลงนาม
        if ($this->authorized_person_id_upload instanceof UploadedFile) {
            $fileName = 'auth_' . $this->company_registration_number . '_' . $timestamp . '.' . $this->authorized_person_id_upload->extension;
            if ($this->authorized_person_id_upload->saveAs($uploadPath . $fileName)) {
                $this->authorized_person_id_file = $fileName;
                $hasUploaded = true;
            }
        }
        
        // อัพโหลดไฟล์สำเนาบัตรประชาชนผู้รับมอบอำนาจ
        if ($this->proxy_person_id_upload instanceof UploadedFile) {
            $fileName = 'proxy_id_' . $this->company_registration_number . '_' . $timestamp . '.' . $this->proxy_person_id_upload->extension;
            if ($this->proxy_person_id_upload->saveAs($uploadPath . $fileName)) {
                $this->proxy_person_id_file = $fileName;
                $hasUploaded = true;
            }
        }
        
        return $hasUploaded;
    }
    
    /**
     * สร้างรหัสผ่านแบบสุ่ม
     * 
     * @param int $length ความยาวของรหัสผ่าน
     * @return string
     */
    public function generateRandomPassword($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomPassword;
    }
    
    /**
     * สร้าง User หลังจากลงทะเบียนสำเร็จ
     * 
     * @return bool
     */
    public function createUser()
    {
        if ($this->status == self::STATUS_APPROVED) {
            $user = new User();
            $user->username = $this->company_registration_number;
            $user->email = $this->email;
            $user->role = User::ROLE_COMPANY;
            $user->status = User::STATUS_ACTIVE;
            $user->company_id = $this->id;
            
            // สร้างรหัสผ่านแบบสุ่ม
            $password = $this->generateRandomPassword(10);
            $user->setPassword($password);
            $user->generateAuthKey();
            
            if ($user->save()) {
                // ส่งอีเมล์แจ้ง username และ password
                $this->sendCredentialsEmail($user->username, $password);
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * ส่งอีเมล์แจ้ง username และ password
     * 
     * @param string $username
     * @param string $password
     * @return bool
     */
    protected function sendCredentialsEmail($username, $password)
    {
        return Yii::$app->mailer->compose()
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setTo($this->email)
            ->setSubject('การลงทะเบียนระบบงานการขออนุญาตให้ใช้รถเพื่อการทดสอบสำเร็จ')
            ->setTextBody(
                "เรียน {$this->company_name}\n\n" .
                "การลงทะเบียนของท่านได้รับการอนุมัติแล้ว\n\n" .
                "ข้อมูลสำหรับเข้าสู่ระบบ:\n" .
                "Username: {$username}\n" .
                "Password: {$password}\n\n" .
                "กรุณาเข้าสู่ระบบและเปลี่ยนรหัสผ่านทันที\n\n" .
                "ขอแสดงความนับถือ\n" .
                Yii::$app->params['senderName']
            )
            ->send();
    }
    
    /**
     * ส่งการแจ้งเตือนผ่าน Telegram
     * 
     * @param string $message ข้อความที่ต้องการส่ง
     * @return bool
     */
    public function sendTelegramNotification($message)
    {
        if (empty(Yii::$app->params['telegramBotToken']) || empty(Yii::$app->params['telegramChatId'])) {
            return false;
        }
        
        $botToken = Yii::$app->params['telegramBotToken'];
        $chatId = Yii::$app->params['telegramChatId'];
        
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ];
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        return (bool) $result;
    }
    
    /**
     * แปลงสถานะเป็นข้อความ
     * 
     * @return string
     */
    public function getStatusText()
    {
        $statusOptions = [
            self::STATUS_PENDING => 'รอการตรวจสอบ',
            self::STATUS_APPROVED => 'อนุมัติแล้ว',
            self::STATUS_REJECTED => 'ไม่อนุมัติ',
        ];
        
        return isset($statusOptions[$this->status]) ? $statusOptions[$this->status] : 'ไม่ทราบสถานะ';
    }

    public function getListPdf($ref)
    {
        $uploadFiles = Uploads::find()->where(['ref' => $this->ref])->all();
        $pdfs = [];
        foreach ($uploadFiles as $file) {
            // Check if the file is a PDF
            if (strpos($file->real_filename, '.pdf') !== false) {
                $pdfs[] = [
                    'url' => self::getUploadUrl(true) . $this->ref . '/' . $file->real_filename,
                    'options' => ['title' => $file->file_name]  // Use the real_filename as the title
                ];
            }
        }
        return $pdfs;  // Return only PDF files
    }
}
