<?php

namespace app\controllers;

use Yii;
use app\models\MacTestVehCertDetail;
use app\models\MacTestVehCertDetailReport;
use app\models\MacTestVehCertDetailSearch;
use app\models\VehTestReportSchedule;
use app\models\VehTestReportScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\db\Expression;
use DateTime;
use yii\data\ActiveDataProvider;

/**
 * TrController implements the CRUD actions for MacTestVehCertDetail model.
 */
class TrController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulkdelete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all MacTestVehCertDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $findName = Yii::$app->user->identity ? Yii::$app->user->identity->find_name : null;

        if (!$findName) {
            // For non-logged in users, create an empty search model instead of null
            $searchModel = new MacTestVehCertDetailSearch();
            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => [],
            ]);
        } else {
            // For logged in users
            $searchModel = new MacTestVehCertDetailSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null, $findName);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexReportSchedule()
    {
        $searchModel = new VehTestReportScheduleSearch();
        // รับค่าจาก URL (GET Parameters)
        $OFF_CODE = Yii::$app->request->get('OFF_CODE');
        $BR_CODE = Yii::$app->request->get('BR_CODE');
        $CAR_TEST_TYPE = Yii::$app->request->get('CAR_TEST_TYPE');
        $CERT_YEAR = Yii::$app->request->get('CERT_YEAR');
        $CERT_NO = Yii::$app->request->get('CERT_NO');
        $PLATE1 = Yii::$app->request->get('PLATE1');
        $PLATE2 = Yii::$app->request->get('PLATE2');
        $CAR_TYPE = Yii::$app->request->get('CAR_TYPE');
        

        $model = $this->findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2);
        // Query ข้อมูลและกรองตามค่าที่รับมา
        $query = VehTestReportSchedule::find()
            ->andFilterWhere(['OFF_CODE' => $OFF_CODE])
            ->andFilterWhere(['BR_CODE' => $BR_CODE])
            ->andFilterWhere(['CAR_TEST_TYPE' => $CAR_TEST_TYPE])
            ->andFilterWhere(['CERT_YEAR' => $CERT_YEAR])
            ->andFilterWhere(['CERT_NO' => $CERT_NO])
            ->andFilterWhere(['PLATE1' => $PLATE1])
            ->andFilterWhere(['PLATE2' => $PLATE2]);

        // ใช้ ActiveDataProvider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20, // กำหนดให้แสดงหน้าละ 20 รายการ
            ],
            'sort' => [
                'defaultOrder' => [
                    'CERT_YEAR' => SORT_DESC, // เรียงลำดับปีล่าสุดก่อน
                ],
            ],
        ]);
        return $this->render('index-report-schedule', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }




    /**
     * Displays a single MacTestVehCertDetail model.
     * @param string $OFF_CODE
     * @param string $BR_CODE
     * @param string $CAR_TEST_TYPE
     * @param string $CERT_YEAR
     * @param string $CERT_NO
     * @param string $CAR_TYPE
     * @param string $PLATE1
     * @param string $PLATE2
     * @return mixed
     */
    public function actionView($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2)
    {
        $model = $this->findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2);
        $modelSchedule = new ActiveDataProvider([
            'query' => VehTestReportSchedule::find()->where(['OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO, 'PLATE1' => $model->PLATE1, 'PLATE2' => $model->PLATE2]),
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]]
        ]);
        $request = Yii::$app->request;

        // ตรวจสอบว่าเจ้าของตรงกับข้อมูลที่ผู้ใช้เข้าสู่ระบบ
        $findName = Yii::$app->user->identity ? Yii::$app->user->identity->find_name : null;

        // เปรียบเทียบ find_name กับ ID_NO ของเจ้าของใน model
        if ($model->macTestVehCert->ID_NO !== $findName) {
            // หากไม่ตรงกัน แสดงข้อความ หรือไม่แสดงข้อมูลใดๆ
            Yii::$app->session->setFlash('error', 'คุณไม่มีสิทธิ์เข้าถึงข้อมูลนี้');
            return $this->redirect(['index']); // หรือ redirect ไปหน้าอื่นที่เหมาะสม
        }

        // หากเป็นเจ้าของหรือข้อมูลตรงกัน
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => 'เลขที่หนังสืออนุญาต : ' . $model->certNo . ' | ' . $model->plate,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                    'modelSchedule' => $modelSchedule,
                ]),
                'footer' => Html::button('ปิดหน้าจอ', ['class' => 'btn btn-danger pull-left', 'data-bs-dismiss' => 'modal']) .
                    Html::a('บันทึกการใช้เครื่องหมายแสดงการใช้รถทดสอบ', [
                        'index-report-schedule',
                        'OFF_CODE' => $OFF_CODE,
                        'BR_CODE' => $BR_CODE,
                        'CAR_TEST_TYPE' => $CAR_TEST_TYPE,
                        'CERT_YEAR' => $CERT_YEAR,
                        'CERT_NO' => $CERT_NO,
                        'CAR_TYPE' => $CAR_TYPE,
                        'PLATE1' => $PLATE1,
                        'PLATE2' => $PLATE2
                    ], ['class' => 'btn btn-primary', 'role' => '#'])
            ];
        } else {
            return $this->render('view2', [
                'model' => $model,
                'modelSchedule' => $modelSchedule,
            ]);
        }
    }



    /**
     * Creates a new MacTestVehCertDetail model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new MacTestVehCertDetail();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'Create New MacTestVehCertDetail',
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('ปิดหน้าจอ', ['class' => 'btn btn-warning pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button('Create', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => 'Create NewMacTestVehCertDetail',
                    'content' => '<span class="text-success">Create MacTestVehCertDetail Success</span>',
                    'footer' =>  Html::button('ปิดหน้าจอ', ['class' => 'btn btn-warning pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => 'Create New MacTestVehCertDetail',
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('ปิดหน้าจอ', ['class' => 'btn btn-warning pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO, 'CAR_TYPE' => $model->CAR_TYPE, 'PLATE1' => $model->PLATE1, 'PLATE2' => $model->PLATE2]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing MacTestVehCertDetail model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $OFF_CODE
     * @param string $BR_CODE
     * @param string $CAR_TEST_TYPE
     * @param string $CERT_YEAR
     * @param string $CERT_NO
     * @param string $CAR_TYPE
     * @param string $PLATE1
     * @param string $PLATE2
     * @return mixed
     */
    public function actionUpdate($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2);
        $model->TEST_DATE = $this->RevertDate($model->TEST_DATE);
        $model->STOP_USE_DATE = $this->RevertDate($model->STOP_USE_DATE);
        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "บันทึกการใช้เครื่องหมายแสดงการใช้รถทดสอบ",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('ปิดหน้าจอ', ['class' => 'btn btn-danger pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button('บันทึก', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post())) {
                $model->TEST_DATE = $this->ConvertDate($model->TEST_DATE);
                $model->STOP_USE_DATE = $this->ConvertDate($model->STOP_USE_DATE);
                $model->IS_REPORT = 'Y';
                $modelReport = new MacTestVehCertDetailReport();

                $modelReport->OFF_CODE = $model->OFF_CODE;
                $modelReport->BR_CODE = $model->BR_CODE;
                $modelReport->CAR_TEST_TYPE = $model->CAR_TEST_TYPE;
                $modelReport->CERT_YEAR = $model->CERT_YEAR;
                $modelReport->CERT_NO = $model->CERT_NO;
                $modelReport->CAR_TYPE = $model->CAR_TYPE;
                $modelReport->PLATE1 = $model->PLATE1;
                $modelReport->PLATE2 = $model->PLATE2;
                $modelReport->NUM_BODY = $model->NUM_BODY;
                $modelReport->ENG_FLAG = $model->ENG_FLAG;
                $modelReport->NUM_ENG = $model->NUM_ENG;
                $modelReport->SERIES_NAME = $model->SERIES_NAME;
                $modelReport->TEST_DATE = $model->TEST_DATE;
                $modelReport->TEST_DISTANCE = $model->TEST_DISTANCE;
                $modelReport->TEST_TIME = $model->TEST_TIME;
                $modelReport->IS_REPORT = $model->IS_REPORT;

                // กำหนดค่าเพิ่มเติมสำหรับ $modelReport
                $modelReport->REPORT_DATE = date('Y-m-d H:i:s');
                $modelReport->UPD_USER_CODE = Yii::$app->user->identity->username;
                $modelReport->LAST_UPD_DATE = date('Y-m-d H:i:s');
                $modelReport->CREATE_USER_CODE = $model->CREATE_USER_CODE ?: Yii::$app->user->identity->username;
                $modelReport->CREATE_DATE = $model->CREATE_DATE ?: date('Y-m-d H:i:s');

                if ($model->save() && $modelReport->save(false)) {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => 'เลขที่หนังสืออนุญาต : ' . $model->certNo . ' | ' . $model->plate,
                        $BR_CODE,
                        $CAR_TEST_TYPE,
                        $CERT_YEAR,
                        $CERT_NO,
                        $CAR_TYPE,
                        $PLATE1,
                        $PLATE2,
                        'content' => $this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'footer' => Html::button('ปิดหน้าจอ', ['class' => 'btn btn-danger pull-left', 'data-bs-dismiss' => 'modal'])
                    ];
                } else {
                    return [
                        'title' =>  'บันทึก',
                        'content' => $this->renderAjax('update', [
                            'model' => $model,
                        ]),
                        'footer' => Html::button('ปิดหน้าจอ', ['class' => 'btn btn-danger pull-left', 'data-bs-dismiss' => 'modal']) .
                            Html::button('Save', ['class' => 'btn btn-primary', 'type' => 'submit'])
                    ];
                }
            } else {
                return [
                    'title' =>  'บันทึก',
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('ปิดหน้าจอ', ['class' => 'btn btn-danger pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO, 'CAR_TYPE' => $model->CAR_TYPE, 'PLATE1' => $model->PLATE1, 'PLATE2' => $model->PLATE2]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }


    /**
     * Delete an existing MacTestVehCertDetail model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $OFF_CODE
     * @param string $BR_CODE
     * @param string $CAR_TEST_TYPE
     * @param string $CERT_YEAR
     * @param string $CERT_NO
     * @param string $CAR_TYPE
     * @param string $PLATE1
     * @param string $PLATE2
     * @return mixed
     */
    public function actionDelete($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2)
    {
        $request = Yii::$app->request;
        $this->findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2)->delete();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing MacTestVehCertDetail model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $OFF_CODE
     * @param string $BR_CODE
     * @param string $CAR_TEST_TYPE
     * @param string $CERT_YEAR
     * @param string $CERT_NO
     * @param string $CAR_TYPE
     * @param string $PLATE1
     * @param string $PLATE2
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the MacTestVehCertDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $OFF_CODE
     * @param string $BR_CODE
     * @param string $CAR_TEST_TYPE
     * @param string $CERT_YEAR
     * @param string $CERT_NO
     * @param string $CAR_TYPE
     * @param string $PLATE1
     * @param string $PLATE2
     * @return MacTestVehCertDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2)
    {
        if (($model = MacTestVehCertDetail::findOne(['OFF_CODE' => $OFF_CODE, 'BR_CODE' => $BR_CODE, 'CAR_TEST_TYPE' => $CAR_TEST_TYPE, 'CERT_YEAR' => $CERT_YEAR, 'CERT_NO' => $CERT_NO, 'CAR_TYPE' => $CAR_TYPE, 'PLATE1' => $PLATE1, 'PLATE2' => $PLATE2])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    ## Customs Function
    public function ConvertDate($date)
    {
        $xdate = strtotime(date($date));
        $y = date('Y', $xdate) + 543;
        $m = date('m', $xdate);
        $d = date('d', $xdate);
        $str_date =  $y . '' . $m . '' . $d;
        return $str_date;
    }
    public function RevertDate($date)
    {
        // ตรวจสอบว่า $date เป็น null หรือว่างเปล่า
        if (empty($date)) {
            return null;
        }

        try {
            $d = substr($date, -2);
            $m = substr($date, -4, 2);
            $y = substr($date, -8, 4) - 543;
            $time = $y . '-' . $m . '-' . $d;

            // ตรวจสอบว่าค่าที่ได้เป็นวันที่ที่ถูกต้องหรือไม่
            $dateTime = new DateTime($time);
            return $dateTime->format('Y-m-d');
        } catch (Exception $e) {
            return null; // ส่งคืนค่า null หากเกิดข้อผิดพลาด
        }
    }

    public function actionExport()
    {
        $findName = Yii::$app->user->identity ? Yii::$app->user->identity->find_name : null;

        if (!$findName) {
            return $this->render('index', [
                'searchModel' => null,
                'dataProvider' => null,
            ]);
        }

        $searchModel = new MacTestVehCertDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null, $findName);
        $totalCount = $dataProvider->getTotalCount();
        $dataProvider->pagination = ['pageSize' => $totalCount];
        $data = $dataProvider->getModels();
        //  VarDumper::dump($data); exit();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template/report001.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();
        $i = 6; // กำหนดค่า i เป็น 6 เพื่อเริ่มพิมพ์ที่แถวที่ 6
        $x = 1;
        //$worksheet->setCellValue('A1', 'LITTLEBOY');
        foreach ($data as $model) {
            // VarDumper::dump($model);
            // exit();
            $worksheet->setCellValue('A' . $i, $x);
            $worksheet->setCellValue('B' . $i, @$model->carTestType);
            $worksheet->setCellValue('C' . $i, @$model->certNo);
            $worksheet->setCellValue('D' . $i, @$model->carType);
            $worksheet->setCellValue('E' . $i, @$model->plate);
            $worksheet->setCellValue('F' . $i, @$model->plateCancel);
            $worksheet->setCellValue('G' . $i, @$model->NUM_BODY);
            $worksheet->setCellValue('H' . $i, @$model->NUM_ENG);
            $worksheet->setCellValue('I' . $i, @$model->SERIES_NAME != null ? $model->SERIES_NAME : '-');
            $worksheet->setCellValue('J' . $i, @$model->TEST_DATE != null ? \app\models\MyDate::getDateThai($model->TEST_DATE) : '-');
            $worksheet->setCellValue('K' . $i, @$model->TEST_DISTANCE != null ? $model->TEST_DISTANCE : '-');
            $worksheet->setCellValue('L' . $i, @$model->TEST_TIME != null ? $model->TEST_TIME : '-');
            $worksheet->setCellValue('M' . $i, @$model->STOP_USE_DATE != null ? \app\models\MyDate::getDateThai($model->STOP_USE_DATE) : '-');
            $worksheet->setCellValue('N' . $i, @$model->sendBackFlag != null ? $model->sendBackFlag : '-');
            $worksheet->setCellValue('O' . $i, @$model->SEND_BACK_DATE != null ? \app\models\MyDate::getDateThai($model->SEND_BACK_DATE) : '-');
            $x++;
            $i++;
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="report001.xlsx"');
        header('Cache-Control: max-age=0');
        Yii::$app->session->setFlash('success', 'export report to excel');
        //$writer->save('server_report001.xlsx');
        $writer->save('php://output');
        exit;
    }
}
