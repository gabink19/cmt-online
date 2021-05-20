<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BidangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bidang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-8">
                <?= $form->field($model, 'tb_id') ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'tb_nama_bidang') ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'tb_keterangan') ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'tb_flag_akses')->dropDownList(
            Yii::$app->params['typeUser'], 
            ['prompt'=>'Pilih Type User...']);
        ?>
        </div>

        <div class="col-md-8 form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
