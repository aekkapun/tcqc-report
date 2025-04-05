<?php

namespace app\controllers;

use Yii;
use app\models\Company;
use app\models\User;
use app\models\search\CompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RegistrationController implements the actions for Company registration.
 */
class RegistrationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['admin-index', 'approve', 'reject', 'verify'],
                'rules' => [
                    [
                        'actions' => ['admin-index', 'approve', 'reject', 'verify'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role == User::ROLE_ADMIN;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'approve' => ['POST'],
                    'reject' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * แสดงฟอร์มลงทะเบียนสำหรับบริษัท
     * @return mixed
     */
/**
 * การลงทะเบียนบริษัทผู้ขออนุญาต ด้วยการอัพโหลดไฟล์แบบ Ajax
 * 
 * @return mixed
 */
public function actionRegister()
{
    // ถ้า login แล้วให้ redirect ไปที่หน้าแรก
   /* if (!Yii::$app->user->isGuest) {
        return $this->redirect(['/site/index']);
    } */
    
    $model = new Company();
    $model->status = Company::STATUS_PENDING;
    
    // สำหรับการอัพโหลดแต่ละไฟล์
    if (Yii::$app->request->isAjax && isset($_FILES)) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // ตรวจสอบว่าอัพโหลดไฟล์ไหน
        if (isset($_FILES['company_certificate_upload'])) {
            $model->company_certificate_upload = UploadedFile::getInstance($model, 'company_certificate_upload');
            $fieldName = 'company_certificate_file';
        } elseif (isset($_FILES['proxy_upload'])) {
            $model->proxy_upload = UploadedFile::getInstance($model, 'proxy_upload');
            $fieldName = 'proxy_file';
        } elseif (isset($_FILES['authorized_person_id_upload'])) {
            $model->authorized_person_id_upload = UploadedFile::getInstance($model, 'authorized_person_id_upload');
            $fieldName = 'authorized_person_id_file';
        } elseif (isset($_FILES['proxy_person_id_upload'])) {
            $model->proxy_person_id_upload = UploadedFile::getInstance($model, 'proxy_person_id_upload');
            $fieldName = 'proxy_person_id_file';
        } else {
            return [
                'success' => false,
                'message' => 'ไม่พบไฟล์ที่อัพโหลด'
            ];
        }
        
        // สร้างโฟลเดอร์ชั่วคราวสำหรับอัพโหลด
        $uploadPath = Yii::getAlias('@webroot/uploads/temp/');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // อัพโหลดไฟล์ไปที่โฟลเดอร์ชั่วคราว
        $timestamp = time();
        $fileName = 'temp_' . $timestamp . '_' . $model->{$model->formName()}->baseName . '.' . $model->{$model->formName()}->extension;
        
        if ($model->{$model->formName()}->saveAs($uploadPath . $fileName)) {
            return [
                'success' => true,
                'message' => 'อัพโหลดไฟล์สำเร็จ',
                'fileName' => $fileName,
                'fieldName' => $fieldName
            ];
        } else {
            return [
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการอัพโหลดไฟล์'
            ];
        }
    }
    
    // การบันทึกข้อมูลลงทะเบียน
    if ($model->load(Yii::$app->request->post())) {
        
        // จัดการกับไฟล์ที่อัพโหลดผ่าน Ajax
        $tempUploadPath = Yii::getAlias('@webroot/uploads/temp/');
        $finalUploadPath = Yii::getAlias('@webroot/uploads/company/');
        
        if (!file_exists($finalUploadPath)) {
            mkdir($finalUploadPath, 0777, true);
        }
        
        // ย้ายไฟล์จากโฟลเดอร์ชั่วคราวไปยังโฟลเดอร์จริง
        $uploadSuccess = true;
        
        // ข้อมูลไฟล์ที่อัพโหลดผ่าน Ajax (ถูกส่งมาในรูปแบบ hidden input)
        if (!empty($model->company_certificate_file)) {
            $tempFile = $tempUploadPath . $model->company_certificate_file;
            if (file_exists($tempFile)) {
                $newFileName = 'cert_' . $model->company_registration_number . '_' . time() . '.' . pathinfo($tempFile, PATHINFO_EXTENSION);
                if (rename($tempFile, $finalUploadPath . $newFileName)) {
                    $model->company_certificate_file = $newFileName;
                } else {
                    $uploadSuccess = false;
                }
            }
        }
        
        if (!empty($model->proxy_file)) {
            $tempFile = $tempUploadPath . $model->proxy_file;
            if (file_exists($tempFile)) {
                $newFileName = 'proxy_' . $model->company_registration_number . '_' . time() . '.' . pathinfo($tempFile, PATHINFO_EXTENSION);
                if (rename($tempFile, $finalUploadPath . $newFileName)) {
                    $model->proxy_file = $newFileName;
                } else {
                    $uploadSuccess = false;
                }
            }
        }
        
        if (!empty($model->authorized_person_id_file)) {
            $tempFile = $tempUploadPath . $model->authorized_person_id_file;
            if (file_exists($tempFile)) {
                $newFileName = 'auth_' . $model->company_registration_number . '_' . time() . '.' . pathinfo($tempFile, PATHINFO_EXTENSION);
                if (rename($tempFile, $finalUploadPath . $newFileName)) {
                    $model->authorized_person_id_file = $newFileName;
                } else {
                    $uploadSuccess = false;
                }
            }
        }
        
        if (!empty($model->proxy_person_id_file)) {
            $tempFile = $tempUploadPath . $model->proxy_person_id_file;
            if (file_exists($tempFile)) {
                $newFileName = 'proxy_id_' . $model->company_registration_number . '_' . time() . '.' . pathinfo($tempFile, PATHINFO_EXTENSION);
                if (rename($tempFile, $finalUploadPath . $newFileName)) {
                    $model->proxy_person_id_file = $newFileName;
                } else {
                    $uploadSuccess = false;
                }
            }
        }
        
        // บันทึกข้อมูล
        if ($uploadSuccess && $model->save()) {
            // ส่ง notification ให้ admin ตรวจสอบ
           // $this->sendRegistrationNotification($model);
            
            Yii::$app->session->setFlash('success', 'ลงทะเบียนเรียบร้อยแล้ว กรุณารอการตรวจสอบข้อมูลจากเจ้าหน้าที่');
            return $this->redirect(['/site/login']);
        }
    }
    
    return $this->render('register', [
        'model' => $model,
    ]);
}
    
    /**
     * แสดงรายการลงทะเบียนรอการตรวจสอบสำหรับ admin
     * @return mixed
     */
    public function actionAdminIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('admin-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * ตรวจสอบเอกสารการลงทะเบียน
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionVerify($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('verify', [
            'model' => $model,
        ]);
    }
    
    /**
     * อนุมัติการลงทะเบียน
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->status = Company::STATUS_APPROVED;
        
        if ($model->save()) {
            // สร้าง User สำหรับบริษัทที่ลงทะเบียน
            if ($model->createUser()) {
                Yii::$app->session->setFlash('success', 'อนุมัติการลงทะเบียนเรียบร้อยแล้ว');
            } else {
                Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาดในการสร้างผู้ใช้งาน');
            }
        } else {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาดในการอนุมัติการลงทะเบียน');
        }
        
        return $this->redirect(['admin-index']);
    }
    
    /**
     * ปฏิเสธการลงทะเบียน
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->status = Company::STATUS_REJECTED;
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'ปฏิเสธการลงทะเบียนเรียบร้อยแล้ว');
        } else {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาดในการปฏิเสธการลงทะเบียน');
        }
        
        return $this->redirect(['admin-index']);
    }
    
    /**
     * ส่ง notification การลงทะเบียนให้ admin
     * @param Company $model
     */
    protected function sendRegistrationNotification($model)
    {
        // ส่งการแจ้งเตือนผ่าน Telegram
        $message = "มีการลงทะเบียนใหม่\n";
        $message .= "บริษัท: {$model->company_name}\n";
        $message .= "เลขทะเบียนนิติบุคคล: {$model->company_registration_number}\n";
        $message .= "อีเมล์: {$model->email}\n";
        $message .= "เบอร์โทรศัพท์: {$model->phone}\n";
        
        // ใช้ Telegram Bot API
        $botToken = Yii::$app->params['telegramBotToken'];
        $chatId = Yii::$app->params['telegramChatId'];
        
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
        ];
        
        // ส่งข้อความผ่าน curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        
        // ส่งอีเมล์แจ้งเตือน admin
        Yii::$app->mailer->compose()
            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
            ->setTo(Yii::$app->params['vehicleDltEmail'])
            ->setSubject('มีการลงทะเบียนใหม่ในระบบขออนุญาตให้ใช้รถเพื่อการทดสอบ')
            ->setTextBody($message)
            ->send();
    }
    
    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('หน้าที่คุณร้องขอไม่มีอยู่.');
    }
}
