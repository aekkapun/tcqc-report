<?php

use app\models\MacTestVehCertDetail;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertDetailSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mac Test Veh Cert Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mac-test-veh-cert-detail-index">

<div class="card">
  <div class="card-header  text-center">
    Featured
  </div>
  <div class="card-body">
        <p>
        <?= Html::a('Create Mac Test Veh Cert Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <hr/>
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
 ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'ผู้ขออนุญาต',
                'value' => function ($model, $key, $index) {
                    return @$model->macTestVehCert->fullName;
                },
            ],
            [
                'label'=>'เลขที่หนังสืออนุญาต',
                'attribute'=>'CERT_NO',
                'value' => function ($model, $key, $index) {
                    return $model->certNo;
                },
            ],
            [
                'label'=>'ประเภทรถ',
                'value' => function ($model, $key, $index) {
                    return $model->carType;
                },
            ],
            [
                'label'=>'เครื่องหมาย',
                'attribute'=>'PLATE2',
                'value' => function ($model, $key, $index) {
                    return $model->plate;
                },
            ],
            // 'PLATE_SEQ',
            'NUM_BODY',
           // 'NUM_ENG',
            [
                'label'=>'วันที่อนุญาต',
                'value' => function ($model, $key, $index) {
                    return \app\models\MyDate::getDateThai(@$model->macTestVehCert->PMT_DATE);
                },
            ],
            [
                'label'=>'วันที่สิ้นอายุ',
                'value' => function ($model, $key, $index) {
                    return \app\models\MyDate::getDateThai(@$model->macTestVehCert->EXP_DATE);
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MacTestVehCertDetail $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO, 'CAR_TYPE' => $model->CAR_TYPE, 'PLATE1' => $model->PLATE1, 'PLATE2' => $model->PLATE2]);
                 }
            ],
        ],
    ]); ?>
  </div>
</div>

</div>
