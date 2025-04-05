<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Registser $model */

$this->title = 'Update Registser: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Registsers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="registser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
