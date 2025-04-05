<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserReq */
?>
<div class="user-req-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            'status',
            'created_at',
            'updated_at',
            'verification_token',
            'title',
            'fname',
            'lname',
            'company',
            'address',
            'find_name',
            'find_option',
            'iss_off_loc_code',
        ],
    ]) ?>

</div>
