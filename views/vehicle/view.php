<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertDetail $model */

$this->title = $model->OFF_CODE;
$this->params['breadcrumbs'][] = ['label' => 'Mac Test Veh Cert Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mac-test-veh-cert-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO, 'CAR_TYPE' => $model->CAR_TYPE, 'PLATE1' => $model->PLATE1, 'PLATE2' => $model->PLATE2], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO, 'CAR_TYPE' => $model->CAR_TYPE, 'PLATE1' => $model->PLATE1, 'PLATE2' => $model->PLATE2], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'OFF_CODE',
            'BR_CODE',
            'CAR_TEST_TYPE',
            'CERT_YEAR',
            'CERT_NO',
            'CAR_TYPE',
            'PLATE1',
            'PLATE2',
            'PLATE_SEQ',
            'NUM_BODY',
            'ENG_FLAG',
            'NUM_ENG',
            'SERIES_NAME',
            'TEST_DATE',
            'TEST_DISTANCE',
            'TEST_TIME:datetime',
            'RENEW_DATE',
            'LAST_CPY_NO',
            'LAST_CPY_DATE',
            'SEND_BACK_DATE',
            'STOP_USE_DATE',
            'SEND_BACK_FLAG',
            'VEH_STATUS',
            'UPD_USER_CODE',
            'LAST_UPD_DATE',
            'CREATE_USER_CODE',
            'CREATE_DATE',
        ],
    ]) ?>

</div>
