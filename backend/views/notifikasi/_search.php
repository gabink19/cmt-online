<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\NotifikasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notifikasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tn_id') ?>

    <?= $form->field($model, 'tn_kepada') ?>

    <?= $form->field($model, 'tn_user_mitra') ?>

    <?= $form->field($model, 'tn_tanggal') ?>

    <?= $form->field($model, 'tn_judul') ?>

    <?php // echo $form->field($model, 'tn_teks') ?>

    <?php // echo $form->field($model, 'tn_type_notif') ?>

    <?php // echo $form->field($model, 'tn_telah_dikirim') ?>

    <?php // echo $form->field($model, 'tn_telah_dibaca') ?>

    <?php // echo $form->field($model, 'tn_tipe_notif') ?>

    <?php // echo $form->field($model, 'tn_link') ?>

    <?php // echo $form->field($model, 'tn_user_id') ?>

    <?php // echo $form->field($model, 'tn_dibaca_tanggal') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
