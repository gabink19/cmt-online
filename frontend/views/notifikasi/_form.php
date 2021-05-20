<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Notifikasi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notifikasi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tn_kepada')->textInput() ?>

    <?= $form->field($model, 'tn_judul')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tn_teks')->textarea(['rows' => 6]) ?>

    

    <!-- <?= $form->field($model, 'tn_user_mitra')->textInput() ?>
    <?= $form->field($model, 'tn_tanggal')->textInput() ?>

    <?= $form->field($model, 'tn_type_notif')->textInput() ?>

    <?= $form->field($model, 'tn_telah_dikirim')->textInput() ?>

    <?= $form->field($model, 'tn_telah_dibaca')->textInput() ?>

    <?= $form->field($model, 'tn_tipe_notif')->textInput() ?>

    <?= $form->field($model, 'tn_link')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tn_user_id')->textInput() ?>

    <?= $form->field($model, 'tn_dibaca_tanggal')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
