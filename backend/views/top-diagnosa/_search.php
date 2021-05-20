<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TopDiagnosaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="top-diagnosa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ttd_id') ?>

    <?= $form->field($model, 'ttd_penamaan') ?>

    <?= $form->field($model, 'ttd_deskripsi') ?>

    <?= $form->field($model, 'ttd_tdg_kode') ?>

    <?= $form->field($model, 'flag_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
