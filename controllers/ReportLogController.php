<?php

namespace app\controllers;

use app\models\MacTestVehCertDetailReport;
use app\models\MacTestVehCertDetailReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * ReportLogController implements the CRUD actions for MacTestVehCertDetailReport model.
 */
class ReportLogController extends Controller
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
     * Lists all MacTestVehCertDetailReport models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $findName = Yii::$app->user->identity ? Yii::$app->user->identity->find_name : null;

        if (!$findName) {
            // For non-logged in users, create an empty search model instead of null
            $searchModel = new MacTestVehCertDetailReportSearch();
            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => [],
            ]);
        } else {
            // For logged in users
            $searchModel = new MacTestVehCertDetailReportSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null, $findName);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single MacTestVehCertDetailReport model.
     * @param int $ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID),
        ]);
    }

    /**
     * Creates a new MacTestVehCertDetailReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MacTestVehCertDetailReport();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'ID' => $model->ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MacTestVehCertDetailReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID)
    {
        $model = $this->findModel($ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MacTestVehCertDetailReport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID)
    {
        $this->findModel($ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MacTestVehCertDetailReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ID
     * @return MacTestVehCertDetailReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = MacTestVehCertDetailReport::findOne(['ID' => $ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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

        $searchModel = new MacTestVehCertDetailReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null, $findName);
        $totalCount = $dataProvider->getTotalCount();
        $dataProvider->pagination = ['pageSize' => $totalCount];
        $data = $dataProvider->getModels();
        //  VarDumper::dump($data); exit();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template/report002.xlsx');
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
            $worksheet->setCellValue('F' . $i, @$model->NUM_BODY);
            $worksheet->setCellValue('G' . $i, @$model->NUM_ENG);
            $worksheet->setCellValue('H' . $i, @$model->SERIES_NAME != null ? $model->SERIES_NAME : '-');
            $worksheet->setCellValue('I' . $i, @$model->TEST_DATE != null ? \app\models\MyDate::getDateThai($model->TEST_DATE) : '-');
            $worksheet->setCellValue('J' . $i, @$model->TEST_DISTANCE != null ? $model->TEST_DISTANCE : '-');
            $worksheet->setCellValue('K' . $i, @$model->TEST_TIME != null ? $model->TEST_TIME : '-');
            $worksheet->setCellValue('L' . $i, @$model->REPORT_DATE != null ? Yii::$app->formatter->asDatetime($model->REPORT_DATE) : '-');
            $x++;
            $i++;
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="report002.xlsx"');
        header('Cache-Control: max-age=0');
        Yii::$app->session->setFlash('success', 'export report to excel');
        //$writer->save('server_report001.xlsx');
        $writer->save('php://output');
        exit;
    }
}
