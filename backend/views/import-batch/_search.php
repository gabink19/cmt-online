<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ImportBatchSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="import-batch-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tib_id') ?>

    <?php // $form->field($model, 'tib_filename') ?>

    <?= $form->field($model, 'tib_status') ?>

    <?= $form->field($model, 'tib_date') ?>

    <?= $form->field($model, 'tib_total') ?>

    <?php // echo $form->field($model, 'tib_success') ?>

    <?php // echo $form->field($model, 'tib_failed') ?>

    <?php // echo $form->field($model, 'first_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
