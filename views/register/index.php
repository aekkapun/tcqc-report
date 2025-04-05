<?php

use app\models\Registser;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RegistserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Registsers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registser-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Registser', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ref',
            'dbd_no',
            'dbd_name',
            'dbd_manager',
            //'user_docno',
            //'email:email',
            //'tel',
            //'status',
            //'created_at',
            //'updated_at',
            //'title',
            //'fname',
            //'lname',
            //'company',
            //'address',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Registser $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
