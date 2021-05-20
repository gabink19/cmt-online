<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\HakKelasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hak-kelas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6"> 

    <?= $form->field($model, 'thk_rumah_sakit') ?>

    <?php // $form->field($model, 'I') ?>

    <?php // $form->field($model, 'II') ?>

    <?php // echo $form->field($model, 'III') ?>

    <?php // echo $form->field($model, 'IV') ?>

    <?php // echo $form->field($model, 'V') ?>

    <?php // echo $form->field($model, 'VI') ?>

    <?php // echo $form->field($model, 'VII') ?>

    <?php // echo $form->field($model, 'flag_active') ?>

    <?php // echo $form->field($model, 'flag_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
</div>

    <?php ActiveForm::end(); ?>

</div>
