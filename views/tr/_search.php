<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\car\models\MacTestVehCertSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mac-test-veh-cert-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="panel panel-default">
        <div class="panel-body" style="margin: 10px;">
            <div class="row">
                <div class="col-md-3">

<?php
echo $form->field($model, 'CAR_TEST_TYPE')->radioList([
    'T' => ' รถทดสอบก่อนผลิต',
    'Q' => ' รถทดสอบคุณภาพ'
], [
    'item' => function ($index, $label, $name, $checked, $value) {
        return Html::tag('div', 
            Html::radio($name, $checked, [
                'value' => $value,
                'class' => 'form-check-input' // ✅ ใช้ Bootstrap class เพื่อให้สวยงาม
            ]) . Html::tag('label', $label, ['class' => 'form-check-label']),
            ['class' => 'form-check'] // ✅ จัดให้อยู่ในแนวตั้ง
        );
    }
])->label('ประเภทรถทดสอบ');
?>


                </div>
                <div class="col-md-3">
<?php
echo $form->field($model, 'CAR_TYPE')->radioList([
    '1' => ' รถยนต์',
    '2' => ' รถจักรยานยนต์'
], [
    'item' => function ($index, $label, $name, $checked, $value) {
        return Html::tag('div', 
            Html::radio($name, $checked, [
                'value' => $value,
                'class' => 'form-check-input' // ✅ ใช้ Bootstrap class
            ]) . Html::tag('label', $label, ['class' => 'form-check-label']),
            ['class' => 'form-check'] // ✅ จัดให้อยู่ในแนวตั้ง
        );
    }
])->label('ประเภทรถ');
?>

                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'PLATE1')->textInput(['style' => 'text-transform:uppercase','maxlength' => true,'placeholder'=>'TC/QC'])->label('เครื่องหมาย TC/QC') ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'PLATE2')->textInput(['maxlength' => true ,'placeholder'=>'0001'])->label('หมายเลข') ?>
                </div>
                <div class="col-md-2">
                    <label></label>
                    <div class="form-group">
                        <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> ค้นหา', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-undo" aria-hidden="true"></i> ยกเลิก', ['index'], ['class' => 'btn btn-warning']) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
