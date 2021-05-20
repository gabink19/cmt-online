<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RujukanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rujukan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tr_no_regis') ?>

    <?= $form->field($model, 'tr_no_rujukan') ?>

    <?= $form->field($model, 'tr_tujuan') ?>

    <?= $form->field($model, 'tr_nama_dokter') ?>

    <?php // echo $form->field($model, 'tr_nama_pasien') ?>

    <?php // echo $form->field($model, 'tr_umur') ?>

    <?php // echo $form->field($model, 'tr_nikes') ?>

    <?php // echo $form->field($model, 'tr_nama_kk') ?>

    <?php // echo $form->field($model, 'tr_band') ?>

    <?php // echo $form->field($model, 'tr_hak_kelas') ?>

    <?php // echo $form->field($model, 'tr_anamnese') ?>

    <?php // echo $form->field($model, 'tr_diagnosa') ?>

    <?php // echo $form->field($model, 'tr_tindakan') ?>

    <?php // echo $form->field($model, 'tr_tgl_rujukan') ?>

    <?php // echo $form->field($model, 'tr_nama_jaminan') ?>

    <?php // echo $form->field($model, 'flag_deleted') ?>

    <?php // echo $form->field($model, 'path_file') ?>

    <?php // echo $form->field($model, 'tr_td_id') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
