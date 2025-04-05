<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCert $model */

$this->title = 'Create Mac Test Veh Cert';
$this->params['breadcrumbs'][] = ['label' => 'Mac Test Veh Certs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mac-test-veh-cert-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
