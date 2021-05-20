<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\RoleAccess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-access-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usermode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'menu_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
