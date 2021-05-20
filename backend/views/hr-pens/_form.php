<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\HrPens */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hr-pens-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-8">
    <?= $form->field($model, 'thp_penamaan')->textInput(['maxlength' => true]) ?>
	</div>
    <div class="col-md-8">
    <?= $form->field($model, 'thp_keterangan')->textInput(['maxlength' => true]) ?>
	</div>

    <div class="col-md-8 form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
