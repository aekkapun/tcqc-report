<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCert $model */

$this->title = $model->OFF_CODE;
$this->params['breadcrumbs'][] = ['label' => 'Mac Test Veh Certs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mac-test-veh-cert-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO], [
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
            'TEST_VEH_CODE',
            'TITLE_CODE',
            'ID_NO',
            'FNAME',
            'LNAME',
            'ADDR',
            'DIST_CODE',
            'AMP_CODE',
            'PRV_CODE',
            'PHONE',
            'NUM_CAR',
            'NUM_PLATE',
            'INS_CODE',
            'INS_NO',
            'INS_EXP_DATE',
            'FST_PMT_DATE',
            'PMT_DATE',
            'EXP_DATE',
            'CERT_STATUS',
            'RENEW_DATE',
            'LAST_CPY_NO',
            'LAST_CPY_DATE',
            'STOP_USE_DATE',
            'SEND_BACK_DATE',
            'FNC_DATE',
            'RCP_NO1',
            'RCP_NO2',
            'PRV_OFF_CODE',
            'PRV_BR_CODE',
            'PRV_CAR_TEST_TYPE',
            'PRV_CERT_YEAR',
            'PRV_CERT_NO',
            'UPD_USER_CODE',
            'LAST_UPD_DATE',
            'CREATE_USER_CODE',
            'CREATE_DATE',
        ],
    ]) ?>

</div>
