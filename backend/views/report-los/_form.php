<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReportLos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-los-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tbs_tp_nikes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbs_td_id')->textInput() ?>

    <?= $form->field($model, 'tbs_catatan_mitra')->textInput() ?>

    <?= $form->field($model, 'tbs_path_billing')->textInput() ?>

    <?= $form->field($model, 'tbs_flag_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbs_id_user_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbs_catatan_yakes')->textInput() ?>

    <?= $form->field($model, 'tbs_id_user_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbs_nama_mitra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbs_nama_user_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_billing')->textInput() ?>

    <?= $form->field($model, 'tgl_billing_diresponse')->textInput() ?>

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

    <?= $form->field($model, 'tbs_biaya')->textInput() ?>

    <?= $form->field($model, 'tbs_diagnosa')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
