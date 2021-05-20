<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\BandPosisiSearch */
/* @var $form yii\widgets\ActiveForm */
$session = Yii::$app->session;
$band = $session->get('band');
?>

<div class="band-posisi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6">    

    <?= 
    $form->field($model, 'tbp_penamaan')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Pilih Band Posisi'],
                        'hideSearch' => false,
                        'data' => ArrayHelper::map($band, 'tbp_id', 'tbp_penamaan'),
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
   
    ?>

    <?= $form->field($model, 'tbp_keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
