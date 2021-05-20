<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Pendaftaran;
use kartik\datetime\DateTimePicker;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\PendaftaranSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pendaftaran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6">
    <?php 
    // $form->field($model, 'start_periode')->widget(DateTimePicker::classname(), [
    //                     'options' => ['placeholder' => 'Start Date'],
    //                     // 'value' => isset($_GET['ReportCampaignBroadcastSearch'])?$_GET['ReportCampaignBroadcastSearch']['start_periode']:date('Y-m-d h:i:s'),
    //                     'pluginOptions' => [
    //                         'autoclose' => true,
    //                         'format' => 'yyyy-mm-dd hh:ii:ss',
    //                     ]
    //                 ]);
                ?>
    
    <?php 
    // $form->field($model, 'stop_periode')->widget(DateTimePicker::classname(), [
    //                     'options' => ['placeholder' => 'Stop Date','onchange'=> 'cekDate();'],
    //                     // 'value' => isset($_GET['ReportCampaignBroadcastSearch'])?$_GET['ReportCampaignBroadcastSearch']['stop_periode']:date('Y-m-d h:i:s'),
    //                     'pluginOptions' => [
    //                         'autoclose' => true,
    //                         'format' => 'yyyy-mm-dd hh:ii:ss',
    //                     ]
    //                 ]);
                ?>
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

    <?= 
    $form->field($model, 'td_tp_nikes')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Pilih Nikes'],
                        'hideSearch' => false,
                        'data' => ArrayHelper::map(Pendaftaran::find()->all(),'td_tp_nikes','td_tp_nikes'),
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
   
    ?>
    
    <?= 
    $form->field($model, 'td_tujuan')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Pilih Tujuan'],
                        'hideSearch' => false,
                        'data' => Yii::$app->params['tujuan'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
   
    ?>
    <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
        </div>

        </div>
    </div>

    <!-- <div class="col-md-12 col-xs-12"> -->
        
    <!-- </div> -->

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    function cekDate() {
        var val = $('#pendaftaransearch-start_periode').val();
        var val2 = $('#pendaftaransearch-stop_periode').val();
        if(val >= val2) {
          alert("Start periode should be less than stop periode.");
          $("#pendaftaransearch-stop_periode").val($('#pendaftaransearch-start_periode').val());
        }
        
    }
</script>