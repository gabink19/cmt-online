<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\Peserta;
use frontend\models\Pendaftaran;
use kartik\widgets\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\LoginForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\Persetujuan */
/* @var $form yii\widgets\ActiveForm */
$url = Url::to(['pendaftaran/select']);
?>

<div class="persetujuan-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-8">
        <?php 
        if (!isset($_GET['id'])) {
            echo $form->field($model, 'tpt_tp_nikes')->widget(Select2::classname(), [
                'options' => ['multiple'=>false, 'placeholder' => 'Ketik Nikes ...','onchange'=>'daftarData(this.value);'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => $url,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]);
        }else{
            echo $form->field($model, 'tpt_tp_nikes')->textInput(['maxlength' => true,'readonly' => true]) ;
        }
        ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'nama_peserta')->textInput()->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'nama_pegawai')->textInput()->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'rekmedis')->dropDownList(
                ArrayHelper::map(Pendaftaran::find()->select(['td_id', 'td_rekam_medis'])->all(), 'td_id', 'td_rekam_medis'), 
                ['prompt'=>'Pilih Rekam Medis...','onchange'=>'tujuanDaftar(this.value);','disabled'=>true])->label('Nomor Rekam Medis') ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tujuan')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tpt_td_id')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tpt_path_permintaan_tindak')->widget(FileInput::classname(), [
              // 'options' => ['accept' => 'doc/*'],
               'pluginOptions' => [
                    'width'=> '90%',
                    // 'allowedFileExtensions'=>['txt','csv'],
                    'showPreview' => false,
                    'showCaption' => true,
                    'showRemove' => true,
                    'showCancel' => false,
                    'showUpload' => false,
                ]
          ])->label('Upload File Permintaan Tindak');?>
        </div>
        <!-- <div class="col-md-8">
            <?= '<label class="control-label">Tgl Pemintaan Persetujuan</label>' ?>
            <?= DatePicker::widget([
                'id' => 'tgl_permintaan', 
                'name' => 'Persetujuan[tgl_permintaan]', 
                'attribute' => 'tgl_permintaan', 
                'value' => ($model->tgl_permintaan!='')?$model->tgl_permintaan:date('Y-m-d'),
                'options' => ['placeholder' => 'Pilih Tanggal ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true
                ]
            ]);?>
        </div> -->

        <div class="col-md-8">
            <?= $form->field($model, 'tpt_catatan_mitra')->textArea() ?>
        </div>

        <div class="col-md-8 form-group">
            <?= ($model->tpt_flag_status=='')?Html::submitButton('Submit', ['class' => 'btn btn-success']):''; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $( document ).ready(function() {
        daftarData($('#persetujuan-tpt_tp_nikes').val());
    });
    function tujuanDaftar(value) {
        $('#persetujuan-tpt_td_id').val(value);
        $('#persetujuan-rekmedis').val(value);
        $.ajax({
            url: '<?= Url::to(["persetujuan/tujuan"]) ?>'+'&id='+value, 
            success: function(result){
                $('#persetujuan-tujuan').val(result);
            }
        });
    }
    function rekemed(value) {
        $.ajax({
            url: '<?= Url::to(["persetujuan/rekmedis"]) ?>'+'&id='+value, 
            success: function(result){
                $('#persetujuan-rekmedis').val(result);
                tujuanDaftar(result);
            }
        });
    }
    function daftarData(val) {
        $.ajax({
            url: '<?= Url::to(["billing-sementara/daftar"]) ?>'+'&nikes='+val+'&newrecord='+<?= ($model->isNewRecord)?'true':'false'; ?>,  
            success: function(result){
                if (result==100) {
                    alert('Daftar dengan Nikes tersebut tidak ditemukan.');
                    $('#persetujuan-tpt_tp_nikes').val('').trigger('change');
                    return false;
                }
                
                if (result==101) {
                    alert('Nikes tersebut telah membuat billing final.');
                    $('#persetujuan-tpt_tp_nikes').val('').trigger('change');
                    return false;
                }
                var obj = eval('(' + result + ')');
                $('#persetujuan-nama_pegawai').val(obj.td_tp_nama_kk);
                $('#persetujuan-nama_peserta').val(obj.td_nama_kel);
                // $('#persetujuan-tpt_td_id').val(obj.td_id);
                tujuanDaftar(obj.td_id);
            }
        });
    }
</script>
