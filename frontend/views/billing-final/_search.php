<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Pendaftaran;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\BillingSementaraSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="billing-sementara-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6">

            <?= 
                $form->field($model, 'tbs_tp_nikes')->widget(Select2::classname(), [
                                'options' => ['placeholder' => 'Pilih Nikes'],
                                'hideSearch' => false,
                                'data' => ArrayHelper::map(Pendaftaran::find()->all(),'td_tp_nikes','td_tp_nikes'),
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
           
            ?>

            <?= $form->field($model, 'tbs_td_id') ?>
            <?= $form->field($model, 'start_periode')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Start Date'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-m-d',
                        ]
                    ]);
                ?>

    
            <?= $form->field($model, 'stop_periode')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Stop Date'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-m-d',
                        ]
                    ]);
                ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
