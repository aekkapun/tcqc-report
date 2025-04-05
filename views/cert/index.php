<?php

use app\models\MacTestVehCert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mac Test Veh Certs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mac-test-veh-cert-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mac Test Veh Cert', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'OFF_CODE',
            'BR_CODE',
            'CAR_TEST_TYPE',
            'CERT_YEAR',
            'CERT_NO',
            //'TEST_VEH_CODE',
            //'TITLE_CODE',
            //'ID_NO',
            //'FNAME',
            //'LNAME',
            //'ADDR',
            //'DIST_CODE',
            //'AMP_CODE',
            //'PRV_CODE',
            //'PHONE',
            //'NUM_CAR',
            //'NUM_PLATE',
            //'INS_CODE',
            //'INS_NO',
            //'INS_EXP_DATE',
            //'FST_PMT_DATE',
            //'PMT_DATE',
            //'EXP_DATE',
            //'CERT_STATUS',
            //'RENEW_DATE',
            //'LAST_CPY_NO',
            //'LAST_CPY_DATE',
            //'STOP_USE_DATE',
            //'SEND_BACK_DATE',
            //'FNC_DATE',
            //'RCP_NO1',
            //'RCP_NO2',
            //'PRV_OFF_CODE',
            //'PRV_BR_CODE',
            //'PRV_CAR_TEST_TYPE',
            //'PRV_CERT_YEAR',
            //'PRV_CERT_NO',
            //'UPD_USER_CODE',
            //'LAST_UPD_DATE',
            //'CREATE_USER_CODE',
            //'CREATE_DATE',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MacTestVehCert $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO]);
                 }
            ],
        ],
    ]); ?>


</div>
