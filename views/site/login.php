<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'เข้าสู่ระบบ';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                    <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <h1 class="fs-4 card-title fw-bold mb-4 text-center">เข้าสู่ระบบ</h1>
                                            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->textInput(['type' => 'text'])->label('Username') ?>
                <?= $form->field($model, 'password')->passwordInput()->label('Password') ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-sign-in" aria-hidden="true"></i> เข้าสู่ระบบ', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    <?= Html::resetButton('<i class="fa fa-refresh" aria-hidden="true"></i>  ยกเลิก', ['class' => 'btn btn-danger ', 'name' => 'reset-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
                        </div>
                        <div class="card-footer bg-gradient-warning py-3 border-0">
                            <div class="text-center">
                                 ระบบรายงานการใช้เครื่องหมายแสดงการใช้รถทดสอบ 
                              <hr/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div><!--container-->