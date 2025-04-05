<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Registser $model */

$this->title = 'Create Registser';
$this->params['breadcrumbs'][] = ['label' => 'Registsers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
                            'initialPreview'=>[],
            'initialPreviewConfig'=>[]
    ]) ?>

</div>
