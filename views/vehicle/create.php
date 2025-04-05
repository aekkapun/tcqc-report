<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertDetail $model */

$this->title = 'Create Mac Test Veh Cert Detail';
$this->params['breadcrumbs'][] = ['label' => 'Mac Test Veh Cert Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mac-test-veh-cert-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
