<?php

namespace app\controllers;

use app\models\MacTestVehCertDetail;
use app\models\MacTestVehCertDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VehicleController implements the CRUD actions for MacTestVehCertDetail model.
 */
class VehicleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all MacTestVehCertDetail models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MacTestVehCertDetailSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MacTestVehCertDetail model.
     * @param string $OFF_CODE Off Code
     * @param string $BR_CODE Br Code
     * @param string $CAR_TEST_TYPE Car Test Type
     * @param string $CERT_YEAR Cert Year
     * @param string $CERT_NO Cert No
     * @param string $CAR_TYPE Car Type
     * @param string $PLATE1 Plate1
     * @param string $PLATE2 Plate2
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2)
    {
        return $this->render('view', [
            'model' => $this->findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2),
        ]);
    }

    /**
     * Creates a new MacTestVehCertDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MacTestVehCertDetail();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO, 'CAR_TYPE' => $model->CAR_TYPE, 'PLATE1' => $model->PLATE1, 'PLATE2' => $model->PLATE2]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MacTestVehCertDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $OFF_CODE Off Code
     * @param string $BR_CODE Br Code
     * @param string $CAR_TEST_TYPE Car Test Type
     * @param string $CERT_YEAR Cert Year
     * @param string $CERT_NO Cert No
     * @param string $CAR_TYPE Car Type
     * @param string $PLATE1 Plate1
     * @param string $PLATE2 Plate2
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2)
    {
        $model = $this->findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO, 'CAR_TYPE' => $model->CAR_TYPE, 'PLATE1' => $model->PLATE1, 'PLATE2' => $model->PLATE2]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MacTestVehCertDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $OFF_CODE Off Code
     * @param string $BR_CODE Br Code
     * @param string $CAR_TEST_TYPE Car Test Type
     * @param string $CERT_YEAR Cert Year
     * @param string $CERT_NO Cert No
     * @param string $CAR_TYPE Car Type
     * @param string $PLATE1 Plate1
     * @param string $PLATE2 Plate2
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2)
    {
        $this->findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MacTestVehCertDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $OFF_CODE Off Code
     * @param string $BR_CODE Br Code
     * @param string $CAR_TEST_TYPE Car Test Type
     * @param string $CERT_YEAR Cert Year
     * @param string $CERT_NO Cert No
     * @param string $CAR_TYPE Car Type
     * @param string $PLATE1 Plate1
     * @param string $PLATE2 Plate2
     * @return MacTestVehCertDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO, $CAR_TYPE, $PLATE1, $PLATE2)
    {
        if (($model = MacTestVehCertDetail::findOne(['OFF_CODE' => $OFF_CODE, 'BR_CODE' => $BR_CODE, 'CAR_TEST_TYPE' => $CAR_TEST_TYPE, 'CERT_YEAR' => $CERT_YEAR, 'CERT_NO' => $CERT_NO, 'CAR_TYPE' => $CAR_TYPE, 'PLATE1' => $PLATE1, 'PLATE2' => $PLATE2])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
