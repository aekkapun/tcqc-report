<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertDetailReport $model */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Mac Test Veh Cert Detail Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mac-test-veh-cert-detail-report-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID' => $model->ID], [
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
            'ID',
            'OFF_CODE',
            'BR_CODE',
            'CAR_TEST_TYPE',
            'CERT_YEAR',
            'CERT_NO',
            'CAR_TYPE',
            'PLATE1',
            'PLATE2',
            'NUM_BODY',
            'ENG_FLAG',
            'NUM_ENG',
            'SERIES_NAME',
            'TEST_DATE',
            'TEST_DISTANCE',
            'TEST_TIME:datetime',
            'IS_REPORT',
            'REPORT_DATE',
            'UPD_USER_CODE',
            'LAST_UPD_DATE',
            'CREATE_USER_CODE',
            'CREATE_DATE',
        ],
    ]) ?>

</div>
