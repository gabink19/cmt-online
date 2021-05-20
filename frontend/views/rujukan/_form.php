<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Rujukan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rujukan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tr_no_regis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_no_rujukan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_tujuan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_nama_dokter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_nama_pasien')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_umur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_nikes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_nama_kk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_band')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_hak_kelas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_anamnese')->textInput() ?>

    <?= $form->field($model, 'tr_diagnosa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_tindakan')->textInput() ?>

    <?= $form->field($model, 'tr_tgl_rujukan')->textInput() ?>

    <?= $form->field($model, 'tr_nama_jaminan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flag_deleted')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'path_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tr_td_id')->textInput() ?>

    <?= $form->field($model, 'date_create')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
