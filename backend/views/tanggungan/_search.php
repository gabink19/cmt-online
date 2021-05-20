<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TanggunganSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tanggungan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6">  

    <?= $form->field($model, 'tt_penamaan') ?>

    <?= $form->field($model, 'tt_keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
</div>

    <?php ActiveForm::end(); ?>

</div>
