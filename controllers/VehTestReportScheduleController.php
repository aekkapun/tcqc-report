<?php

namespace app\controllers;

use Yii;
use app\models\VehTestReportSchedule;
use app\models\VehTestReportScheduleSearch;
use app\models\VehTestReportDetail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * VehTestReportScheduleController implements the CRUD actions for VehTestReportSchedule model.
 */
class VehTestReportScheduleController extends Controller
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
     * Lists all VehTestReportSchedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VehTestReportScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single VehTestReportSchedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "VehTestReportSchedule #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                    Html::a(Yii::t('yii2-ajaxcrud', 'Update'), ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new VehTestReportSchedule model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new VehTestReportSchedule();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " VehTestReportSchedule",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Create'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " VehTestReportSchedule",
                    'content' => '<span class="text-success">' . Yii::t('yii2-ajaxcrud', 'Create') . ' VehTestReportSchedule ' . Yii::t('yii2-ajaxcrud', 'Success') . '</span>',
                    'footer' =>  Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::a(Yii::t('yii2-ajaxcrud', 'Create More'), ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Create New') . " VehTestReportSchedule",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing VehTestReportSchedule model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdateX($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $detailModel = VehTestReportDetail::findOne(['schedule_id' => $id, 'report_month' => $model->report_month]);
        if (!$detailModel) {
            $detailModel = new VehTestReportDetail();
            $detailModel->schedule_id = $id;
            $detailModel->report_month = $model->report_month;
        }
        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " VehTestReportSchedule #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'forceClose' => true,
                    'success' => true,
                    'title' => "Create New VehTestReportSchedule",
                    'content' => '<div class="alert alert-success" role="alert">
                                      <div class="d-flex align-items-center">
                                          <i class="fas fa-check-circle fa-2x me-3"></i>
                                          <div>
                                              <h5 class="mb-0">บันทึกข้อมูลเรียบร้อยแล้ว!</h5>
                                              <p class="mb-0">ข้อมูล VehTestReportSchedule ถูกสร้างเรียบร้อยแล้ว</p>
                                          </div>
                                      </div>
                                  </div>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => Yii::t('yii2-ajaxcrud', 'Update') . " VehTestReportSchedule #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button(Yii::t('yii2-ajaxcrud', 'Close'), ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button(Yii::t('yii2-ajaxcrud', 'Save'), ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        // Set actual_report_date to the current date
        $model->actual_report_date = date('Y-m-d');

        // สร้างหรือโหลดข้อมูล VehTestReportDetail
        $detailModel = VehTestReportDetail::findOne(['schedule_id' => $id, 'report_month' => $model->report_month]);
        if (!$detailModel) {
            $detailModel = new VehTestReportDetail();
            $detailModel->schedule_id = $id;
            $detailModel->report_month = $model->report_month;
        }

        if ($request->isAjax) {
            /*
         *   Process for ajax request
         */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => " รายงานข้อมูลการทดสอบ รอบวันที่  :" . $model->report_date,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'detailModel' => $detailModel,
                    ]),
                    'footer' => Html::button('ปิดหน้าจอ', ['class' => 'btn btn-danger pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button('บันทึกข้อมูล', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            } else if ($model->load($request->post()) && $detailModel->load($request->post())) {
                // เริ่ม Transaction
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // บันทึกข้อมูลตาราง VehTestReportSchedule
                    if (!$model->save()) {
                        throw new \Exception('ไม่สามารถบันทึกข้อมูลหลักได้: ' . json_encode($model->errors));
                    }

                    // อัพเดทข้อมูลผู้บันทึกล่าสุด
                    $detailModel->updated_by = Yii::$app->user->id;
                    if (!$detailModel->created_by) {
                        $detailModel->created_by = Yii::$app->user->id;
                    }

                    // บันทึกข้อมูลตาราง VehTestReportDetail
                    if (!$detailModel->save()) {
                        throw new \Exception('ไม่สามารถบันทึกข้อมูลรายละเอียดได้: ' . json_encode($detailModel->errors));
                    }

                    // อัพเดทสถานะการรายงาน ถ้ามีการกรอกข้อมูลทดสอบครบถ้วน
                    // อัพเดทสถานะการรายงาน ถ้ามีการกรอกข้อมูลทดสอบครบถ้วน
                    if (!empty($detailModel->test_date_from) && !empty($detailModel->test_date_to)) {
                        // Debug information
                        Yii::info('Actual report date: ' . $model->actual_report_date . ' (timestamp: ' . strtotime($model->actual_report_date) . ')');
                        Yii::info('Report date: ' . $model->report_date . ' (timestamp: ' . strtotime($model->report_date) . ')');

                        // Ensure dates are properly formatted for comparison
                        $actualTimestamp = strtotime($model->actual_report_date);
                        $requiredTimestamp = strtotime($model->report_date);

                        // ถ้ารายงานทันตามกำหนด
                        if ($actualTimestamp <= $requiredTimestamp) {
                            Yii::info('Report submitted on time');
                            $model->report_status = 'reported';
                        } else {
                            // ถ้ารายงานล่าช้า
                            Yii::info('Report submitted late: ' . ($actualTimestamp - $requiredTimestamp) . ' seconds difference');
                            $model->report_status = 'late';
                            $model->is_fined = 1;
                            $model->fine_amount = 200; // ค่าปรับตามที่กำหนด
                        }
                        $model->save();
                    }

                    // บันทึกข้อมูลประวัติการทำงาน
                    /* try {
                         // ใช้ AuditTrail โดยตรง
                         $trail = new \bedezign\yii2\audit\models\AuditTrail();
                         $trail->action = 'UPDATE_REPORT';
                         $trail->user_id = Yii::$app->user->id;
                         $trail->message = 'แก้ไขข้อมูลรายงานการใช้เครื่องหมาย #' . $id;
                         $trail->save();
                     } catch (\Exception $e) {
                         // ถ้าบันทึกประวัติไม่สำเร็จ ไม่ต้องยกเลิก Transaction
                         Yii::error('ไม่สามารถบันทึกประวัติการทำงานได้: ' . $e->getMessage());
                     }
                         */

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'forceClose' => true,
                        'success' => true,
                        'showAlert' => true, // เพิ่มพารามิเตอร์นี้เพื่อบอกว่าให้แสดง alert
                        'alertMessage' => 'บันทึกข้อมูลเรียบร้อยแล้ว', // ข้อความที่จะแสดงใน alert
                        'alertType' => 'success', // ประเภทของ alert (success, info, warning, error)
                        'title' => "VehTestReportSchedule #" . $id,
                        'content' => $this->renderAjax('view', [
                            'model' => $model,
                            'detailModel' => $detailModel,
                        ]),
                        'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-bs-dismiss' => 'modal']) .
                            Html::a('Update', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                    ];
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'forceClose' => true,
                        'success' => true,
                        'title' => "Update VehTestReportSchedule #" . $id,
                        'content' => $this->renderAjax('update', [
                            'model' => $model,
                            'detailModel' => $detailModel,
                        ]),
                        'footer' => Html::button('ปิดหน้าจอ', ['class' => 'btn btn-danger pull-left', 'data-bs-dismiss' => 'modal']) .
                            Html::button('Save', ['class' => 'btn btn-primary', 'type' => 'submit']),
                        'error' => $e->getMessage()
                    ];
                }
            } else {
                // ส่วนนี้คือกรณีที่ POST request แต่ model validation ไม่ผ่าน
                return [
                    'title' => "Update VehTestReportSchedule #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'detailModel' => $detailModel,
                    ]),
                    'footer' => Html::button('ปิดหน้าจอ', ['class' => 'btn btn-danger pull-left', 'data-bs-dismiss' => 'modal']) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        } else {
            /*
         *   Process for non-ajax request
         */
            if ($model->load($request->post()) && $detailModel->load($request->post())) {
                // เริ่ม Transaction
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // บันทึกข้อมูลตาราง VehTestReportSchedule
                    if (!$model->save()) {
                        throw new \Exception('ไม่สามารถบันทึกข้อมูลหลักได้');
                    }

                    // อัพเดทข้อมูลผู้บันทึกล่าสุด
                    $detailModel->updated_by = Yii::$app->user->id;
                    if (!$detailModel->created_by) {
                        $detailModel->created_by = Yii::$app->user->id;
                    }

                    // บันทึกข้อมูลตาราง VehTestReportDetail
                    if (!$detailModel->save()) {
                        throw new \Exception('ไม่สามารถบันทึกข้อมูลรายละเอียดได้');
                    }

                    // อัพเดทสถานะการรายงาน ถ้ามีการกรอกข้อมูลทดสอบครบถ้วน
                    if (!empty($detailModel->test_date_from) && !empty($detailModel->test_date_to)) {
                        // ถ้ารายงานทันตามกำหนด
                        if (strtotime($model->actual_report_date) <= strtotime($model->report_date)) {
                            $model->report_status = 'reported';
                        } else {
                            // ถ้ารายงานล่าช้า
                            $model->report_status = 'late';
                            $model->is_fined = true;
                            $model->fine_amount = 200; // ค่าปรับตามที่กำหนด
                        }
                        $model->save();
                    }

                    /* // บันทึกข้อมูลประวัติการทำงาน
                     try {
                         // ใช้ AuditTrail โดยตรง
                         $trail = new \bedezign\yii2\audit\models\AuditTrail();
                         $trail->action = 'UPDATE_REPORT';
                         $trail->user_id = Yii::$app->user->id;
                         $trail->message = 'แก้ไขข้อมูลรายงานการใช้เครื่องหมาย #' . $id;
                         $trail->save();
                     } catch (\Exception $e) {
                         // ถ้าบันทึกประวัติไม่สำเร็จ ไม่ต้องยกเลิก Transaction
                         Yii::error('ไม่สามารถบันทึกประวัติการทำงานได้: ' . $e->getMessage());
                     }
                         */

                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $model->id]);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }

            return $this->render('update', [
                'model' => $model,
                'detailModel' => $detailModel,
            ]);
        }
    }

    /**
     * Delete an existing VehTestReportSchedule model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

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
     * Delete multiple existing VehTestReportSchedule model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * Finds the VehTestReportSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VehTestReportSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VehTestReportSchedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
