<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CmsPortalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cms-portal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'banner1') ?>

    <?= $form->field($model, 'banner2') ?>

    <?= $form->field($model, 'banner3') ?>

    <?= $form->field($model, 'banner4') ?>

    <?php // echo $form->field($model, 'banner5') ?>

    <?php // echo $form->field($model, 'fitur1') ?>

    <?php // echo $form->field($model, 'fitur2') ?>

    <?php // echo $form->field($model, 'fitur3') ?>

    <?php // echo $form->field($model, 'deskripsi') ?>

    <?php // echo $form->field($model, 'deskripsi_img1') ?>

    <?php // echo $form->field($model, 'deskripsi_img2') ?>

    <?php // echo $form->field($model, 'deskripsi_img3') ?>

    <?php // echo $form->field($model, 'deskripsi_text1') ?>

    <?php // echo $form->field($model, 'deskripsi_text2') ?>

    <?php // echo $form->field($model, 'deskripsi_text3') ?>

    <?php // echo $form->field($model, 'partner_img') ?>

    <?php // echo $form->field($model, 'partner_text') ?>

    <?php // echo $form->field($model, 'last_update') ?>

    <?php // echo $form->field($model, 'last_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
