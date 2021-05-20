<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use backend\models\HakKelas;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\ReportTrackingHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-tracking-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6"> 

    <?= $form->field($model, 'start_periode')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Start Date'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                        ]
                    ]); ?>

    <?= $form->field($model, 'stop_periode')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Start Date'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                        ]
                    ]); ?>

    <?= $form->field($model, 'host')->dropDownList(Yii::$app->params['kat_host'], ['prompt'=>'All']); ?>

    <?= $form->field($model, 'tujuan')->dropDownList(Yii::$app->params['tujuan'], ['prompt'=>'All']); ?>

    <?= 
    $form->field($model, 'mitra')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Pilih Mitra'],
                        'hideSearch' => false,
                        'data' => ArrayHelper::map(HakKelas::find()->all(),'thk_rumah_sakit','thk_rumah_sakit'),
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
   
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
