<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Golongan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="golongan-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-8">
    <?= $form->field($model, 'tg_penamaan')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="col-md-8">
    <?= $form->field($model, 'tg_keterangan')->textInput(['maxlength' => true]) ?>
	</div>

    <div class="col-md-8 form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
