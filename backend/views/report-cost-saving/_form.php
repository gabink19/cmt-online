<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PersetujuanTindak */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="persetujuan-tindak-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tpt_uniq_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tpt_tp_nikes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tpt_td_id')->textInput() ?>

    <?= $form->field($model, 'tpt_catatan_mitra')->textInput() ?>

    <?= $form->field($model, 'tpt_path_permintaan_tindak')->textInput() ?>

    <?= $form->field($model, 'tpt_flag_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tpt_id_user_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tpt_catatan_yakes')->textInput() ?>

    <?= $form->field($model, 'tpt_id_user_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tpt_nama_mitra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tpt_nama_user_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_permintaan')->textInput() ?>

    <?= $form->field($model, 'tgl_persetujuan')->textInput() ?>

    <?= $form->field($model, 'first_ip_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_ip_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_ip_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_ip_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_date_backend')->textInput() ?>

    <?= $form->field($model, 'last_date_backend')->textInput() ?>

    <?= $form->field($model, 'first_date_frontend')->textInput() ?>

    <?= $form->field($model, 'last_date_frontend')->textInput() ?>

    <?= $form->field($model, 'first_user_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_user_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_user_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_user_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flag_deleted')->textInput() ?>

    <?= $form->field($model, 'tpt_diagnosa')->textInput() ?>

    <?= $form->field($model, 'history_note')->textInput() ?>

    <?= $form->field($model, 'biaya')->textInput() ?>

    <?= $form->field($model, 'biaya_disetujui')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
