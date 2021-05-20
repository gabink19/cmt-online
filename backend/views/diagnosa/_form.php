<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Diagnosa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="diagnosa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tdg_penamaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tdg_keterangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tdg_kode')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
