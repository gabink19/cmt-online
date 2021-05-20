<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'auth_key') ?>

    <?= $form->field($model, 'password_hash') ?>

    <?= $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'first_user') ?>

    <?php // echo $form->field($model, 'first_ip') ?>

    <?php // echo $form->field($model, 'first_update') ?>

    <?php // echo $form->field($model, 'last_user') ?>

    <?php // echo $form->field($model, 'last_ip') ?>

    <?php // echo $form->field($model, 'last_update') ?>

    <?php // echo $form->field($model, 'active_date') ?>

    <?php // echo $form->field($model, 'usermode') ?>

    <?php // echo $form->field($model, 'flag_multiple') ?>

    <?php // echo $form->field($model, 'last_action') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'flag_login') ?>

    <?php // echo $form->field($model, 'lastvisit') ?>

    <?php // echo $form->field($model, 'no_telp') ?>

    <?php // echo $form->field($model, 'nama') ?>

    <?php // echo $form->field($model, 'bidang_user') ?>

    <?php // echo $form->field($model, 'flag_active') ?>

    <?php // echo $form->field($model, 'rs_mitra') ?>

    <?php // echo $form->field($model, 'bidang_mitra') ?>

    <?php // echo $form->field($model, 'alamat_rs') ?>

    <?php // echo $form->field($model, 'type_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
