<?php

namespace app\controllers;

use app\models\MacTestVehCert;
use app\models\MacTestVehCertSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CertController implements the CRUD actions for MacTestVehCert model.
 */
class CertController extends Controller
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
     * Lists all MacTestVehCert models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MacTestVehCertSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MacTestVehCert model.
     * @param string $OFF_CODE Off Code
     * @param string $BR_CODE Br Code
     * @param string $CAR_TEST_TYPE Car Test Type
     * @param string $CERT_YEAR Cert Year
     * @param string $CERT_NO Cert No
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO)
    {
        return $this->render('view', [
            'model' => $this->findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO),
        ]);
    }

    /**
     * Creates a new MacTestVehCert model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MacTestVehCert();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MacTestVehCert model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $OFF_CODE Off Code
     * @param string $BR_CODE Br Code
     * @param string $CAR_TEST_TYPE Car Test Type
     * @param string $CERT_YEAR Cert Year
     * @param string $CERT_NO Cert No
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO)
    {
        $model = $this->findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MacTestVehCert model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $OFF_CODE Off Code
     * @param string $BR_CODE Br Code
     * @param string $CAR_TEST_TYPE Car Test Type
     * @param string $CERT_YEAR Cert Year
     * @param string $CERT_NO Cert No
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO)
    {
        $this->findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MacTestVehCert model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $OFF_CODE Off Code
     * @param string $BR_CODE Br Code
     * @param string $CAR_TEST_TYPE Car Test Type
     * @param string $CERT_YEAR Cert Year
     * @param string $CERT_NO Cert No
     * @return MacTestVehCert the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($OFF_CODE, $BR_CODE, $CAR_TEST_TYPE, $CERT_YEAR, $CERT_NO)
    {
        if (($model = MacTestVehCert::findOne(['OFF_CODE' => $OFF_CODE, 'BR_CODE' => $BR_CODE, 'CAR_TEST_TYPE' => $CAR_TEST_TYPE, 'CERT_YEAR' => $CERT_YEAR, 'CERT_NO' => $CERT_NO])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
