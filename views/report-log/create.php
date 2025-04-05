<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertDetailReport $model */

$this->title = 'Create Mac Test Veh Cert Detail Report';
$this->params['breadcrumbs'][] = ['label' => 'Mac Test Veh Cert Detail Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mac-test-veh-cert-detail-report-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
