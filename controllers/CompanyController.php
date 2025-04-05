<?php

namespace app\controllers;

use Yii;
use app\models\Company;
use app\models\CompanySearch;
use app\models\Uploads;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\FileHelper;
use yii\helpers\html;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


class CompanyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'upload-file' => ['POST'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $pdfs = $model->getListPdf($model->ref);
        return $this->render('view', [
            'model' => $model,
            'pdfs' => $pdfs
        ]);
    }
    /**
     * แสดงฟอร์มสร้างบริษัทใหม่
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();

        if ($model->load(Yii::$app->request->post())) {

            $this->Uploads(false);

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลบริษัทเรียบร้อยแล้ว');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->ref = substr(Yii::$app->getSecurity()->generateRandomString(), 10);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * แสดงฟอร์มแก้ไขบริษัท
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException ถ้าหากไม่พบโมเดล
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        list($initialPreview, $initialPreviewConfig) = $this->getInitialPreview($model->ref);

        if ($model->load(Yii::$app->request->post())) {
            $this->Uploads(false);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        //remove upload file & data
        $this->removeUploadDir($model->ref);
        Uploads::deleteAll(['ref' => $model->ref]);

        $model->delete();
        Yii::$app->session->setFlash('success', 'ลบข้อมูลบริษัทเรียบร้อยแล้ว');
        return $this->redirect(['index']);
    }
    /**
     * อนุมัติบริษัท
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException ถ้าไม่พบโมเดล
     */
    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->status = Company::STATUS_APPROVED;

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'อนุมัติบริษัทเรียบร้อยแล้ว');
        } else {
            Yii::$app->session->setFlash('error', 'ไม่สามารถอนุมัติบริษัทได้');
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * ไม่อนุมัติบริษัท
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException ถ้าไม่พบโมเดล
     */
    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->status = Company::STATUS_REJECTED;

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'ไม่อนุมัติบริษัทเรียบร้อยแล้ว');
        } else {
            Yii::$app->session->setFlash('error', 'ไม่สามารถดำเนินการได้');
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * ฟังก์ชันจัดการกับไฟล์อัปโหลดปกติ (ไม่ใช่ AJAX)
     * @param Company $model
     */
    protected function processUploadFiles($model)
    {
        // ตรวจสอบการอัปโหลดไฟล์แบบปกติ (ไม่ใช่ AJAX)
        $uploadFields = [
            'company_certificate_upload' => 'company_certificate_file',
            'proxy_upload' => 'proxy_file',
            'authorized_person_id_upload' => 'authorized_person_id_file',
            'proxy_person_id_upload' => 'proxy_person_id_file'
        ];

        foreach ($uploadFields as $uploadField => $dbField) {
            $uploadedFile = UploadedFile::getInstance($model, $uploadField);

            if ($uploadedFile !== null) {
                $uploadDir = Yii::getAlias('@webroot/uploads/company/');
                FileHelper::createDirectory($uploadDir);

                $fileName = uniqid() . '_' . $uploadedFile->baseName . '.' . $uploadedFile->extension;
                $filePath = $uploadDir . $fileName;

                if ($uploadedFile->saveAs($filePath)) {
                    $model->$dbField = '/uploads/company/' . $fileName;
                }
            }
        }
    }

    /**
     * จัดการกับการอัปโหลดไฟล์ผ่าน AJAX
     * @return Response
     */
    public function actionUploadFile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $fieldName = Yii::$app->request->post('fieldName');
        $dbField = Yii::$app->request->post('dbField');

        // ตรวจสอบว่า fieldName ถูกส่งมาหรือไม่
        if (empty($fieldName) || empty($dbField)) {
            return [
                'success' => false,
                'message' => 'ข้อมูลไม่ครบถ้วน',
            ];
        }

        // รับไฟล์ที่อัปโหลด
        $uploadedFile = UploadedFile::getInstanceByName('file');

        // ตรวจสอบว่ามีไฟล์อัปโหลดหรือไม่
        if ($uploadedFile === null) {
            return [
                'success' => false,
                'message' => 'ไม่พบไฟล์อัปโหลด',
            ];
        }

        // ตรวจสอบประเภทไฟล์ (เฉพาะ PDF)
        if ($uploadedFile->type !== 'application/pdf') {
            return [
                'success' => false,
                'message' => 'กรุณาอัปโหลดไฟล์ PDF เท่านั้น',
            ];
        }

        // ตรวจสอบขนาดไฟล์ (ไม่เกิน 5MB)
        if ($uploadedFile->size > 5 * 1024 * 1024) {
            return [
                'success' => false,
                'message' => 'ไฟล์มีขนาดใหญ่เกินไป (สูงสุด 5MB)',
            ];
        }

        // สร้างโฟลเดอร์สำหรับเก็บไฟล์ถ้ายังไม่มี
        $uploadDir = Yii::getAlias('@webroot/uploads/company/');
        FileHelper::createDirectory($uploadDir);

        // สร้างชื่อไฟล์ที่ไม่ซ้ำกัน
        $fileName = uniqid() . '_' . $uploadedFile->baseName . '.' . $uploadedFile->extension;
        $filePath = $uploadDir . $fileName;
        $webPath = '/uploads/company/' . $fileName;

        // บันทึกไฟล์
        if ($uploadedFile->saveAs($filePath)) {
            return [
                'success' => true,
                'message' => 'อัปโหลดไฟล์สำเร็จ',
                'fileName' => $fileName,
                'filePath' => $webPath,
                'fileSize' => Yii::$app->formatter->asShortSize($uploadedFile->size, 2),
                'fileType' => $uploadedFile->type,
                'dbField' => $dbField
            ];
        } else {
            return [
                'success' => false,
                'message' => 'ไม่สามารถบันทึกไฟล์ได้',
            ];
        }
    }

    /**
     * ดาวน์โหลดไฟล์
     * @param string $field ชื่อฟิลด์ในฐานข้อมูล
     * @param integer $id รหัสบริษัท (ถ้าไม่ระบุจะใช้ session)
     * @return mixed
     * @throws NotFoundHttpException ถ้าหากไม่พบไฟล์
     */
    public function actionDownload($field, $id = null)
    {
        if ($id === null && !Yii::$app->user->isGuest) {
            // ใช้ ID จาก session ถ้าไม่ได้ระบุ ID
            $id = Yii::$app->session->get('company_id');
        }

        if ($id === null) {
            throw new NotFoundHttpException('ไม่พบไฟล์ที่ต้องการ');
        }

        $model = $this->findModel($id);

        // ตรวจสอบว่าฟิลด์ที่ต้องการดาวน์โหลดมีอยู่จริง
        $allowedFields = [
            'company_certificate_file',
            'proxy_file',
            'authorized_person_id_file',
            'proxy_person_id_file'
        ];

        if (!in_array($field, $allowedFields) || empty($model->$field)) {
            throw new NotFoundHttpException('ไม่พบไฟล์ที่ต้องการ');
        }

        $filePath = Yii::getAlias('@webroot') . $model->$field;

        if (file_exists($filePath)) {
            return Yii::$app->response->sendFile($filePath, basename($filePath));
        } else {
            throw new NotFoundHttpException('ไม่พบไฟล์ที่ต้องการ');
        }
    }

    /**
     * ค้นหาโมเดล Company จาก ID
     * @param integer $id
     * @return Company โมเดลที่พบ
     * @throws NotFoundHttpException ถ้าหากไม่พบโมเดล
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('ไม่พบหน้าที่คุณต้องการ');
    }


    public function actionUploadAjax()
    {
        $this->Uploads(true);
    }
    public function actionUploadimg()
    {
        $this->Uploads(true);
    }

    private function CreateDir($folderName)
    {
        if ($folderName != NULL) {
            $basePath = Company::getUploadPath();
            if (BaseFileHelper::createDirectory($basePath . $folderName, 0777)) {
                BaseFileHelper::createDirectory($basePath . $folderName . '/thumbnail', 0777);
            }
        }
        return;
    }

    private function removeUploadDir($dir)
    {
        BaseFileHelper::removeDirectory(Company::getUploadPath() . $dir);
    }

    private function Uploads($isAjax = false)
    {
        if (Yii::$app->request->isPost) {
            $images = UploadedFile::getInstancesByName('upload_ajax');
            if ($images) {

                if ($isAjax === true) {
                    $ref = Yii::$app->request->post('ref');
                } else {
                    $PhotoLibrary = Yii::$app->request->post('Company');
                    $ref = $PhotoLibrary['ref'];
                }

                $this->CreateDir($ref);

                foreach ($images as $file) {
                    $fileName       = $file->baseName . '.' . $file->extension;
                    $realFileName   = md5($file->baseName . time()) . '.' . $file->extension;
                    $savePath       = Company::UPLOAD_FOLDER . '/' . $ref . '/' . $realFileName;
                    if ($file->saveAs($savePath)) {

                        if ($this->isImage(Url::base(true) . '/' . $savePath)) {
                            $this->createThumbnail($ref, $realFileName);
                        }

                        $model                  = new Uploads;
                        $model->ref             = $ref;
                        $model->file_name       = $fileName;
                        $model->real_filename   = $realFileName;
                        $model->save();

                        if ($isAjax === true) {
                            echo json_encode(['success' => 'true']);
                        }
                    } else {
                        if ($isAjax === true) {
                            echo json_encode(['success' => 'false', 'eror' => $file->error]);
                        }
                    }
                }
            }
        }
    }

    private function getInitialPreviewOld($ref)
    {
        $datas = Uploads::find()->where(['ref' => $ref])->all();
        $initialPreview = [];
        $initialPreviewConfig = [];
        foreach ($datas as $key => $value) {
            array_push($initialPreview, $this->getTemplatePreview($value));
            array_push($initialPreviewConfig, [
                'type' => 'pdf',
                'caption' => $value->file_name,
                'width'  => '120px',
                'url'    => Url::to(['/company/deletefile-ajax']),
                'key'    => $value->upload_id
            ]);
        }
        return  [$initialPreview, $initialPreviewConfig];
    }
    private function getInitialPreview($ref)
    {
        $datas = Uploads::find()->where(['ref' => $ref])->all();
        $initialPreview = [];
        $initialPreviewConfig = [];

        foreach ($datas as $key => $value) {
            // Add file to preview array
            array_push($initialPreview, $this->getTemplatePreview($value));

            // Add file config
            array_push($initialPreviewConfig, [
                'type' => 'pdf',  // Specify type as PDF
                'caption' => $value->file_name,
                'width' => '120px',
                'url' => Url::to(['/company/deletefile-ajax']),
                'key' => $value->upload_id
            ]);
        }

        return [$initialPreview, $initialPreviewConfig];
    }

    public function isImage($filePath)
    {
        return @is_array(getimagesize($filePath)) ? true : false;
    }

    private function getTemplatePreview(Uploads $model)
    {
        $filePath = Company::getUploadUrl() . $model->ref . '/thumbnail/' . $model->real_filename;
        $isImage  = $this->isImage($filePath);
        if ($isImage) {
            $file = Html::img($filePath, ['class' => 'file-preview-image', 'alt' => $model->file_name, 'title' => $model->file_name]);
        } else {
            $file =  "<div class='file-preview-other'> " .
                "<h2><i class='glyphicon glyphicon-file'></i></h2>" .
                "</div>";
        }
        return $file;
    }

    private function createThumbnail($folderName, $fileName, $width = 250)
    {
        $uploadPath   = Company::getUploadPath() . '/' . $folderName . '/';
        $file         = $uploadPath . $fileName;
        $image        = Yii::$app->image->load($file);
        $image->resize($width);
        $image->save($uploadPath . 'thumbnail/' . $fileName);
        return;
    }

    public function actionDeletefileAjax()
    {

        $model = Uploads::findOne(Yii::$app->request->post('key'));
        if ($model !== NULL) {
            $filename  = Company::getUploadPath() . $model->ref . '/' . $model->real_filename;
            $thumbnail = Company::getUploadPath() . $model->ref . '/thumbnail/' . $model->real_filename;
            if ($model->delete()) {
                @unlink($filename);
                @unlink($thumbnail);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
