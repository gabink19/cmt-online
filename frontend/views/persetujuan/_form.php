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

$q = 'select tdg_penamaan from tbl_diagnosa where tdg_id="'.$model->tpt_diagnosa.'"';
$d = Yii::$app->db->createCommand($q)->queryScalar();
$diagnosa = $d;
?>

<div class="persetujuan-form">

    <?php $form = ActiveForm::begin(['id'=>'persetujuanBaru','options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-8">
        <?php 
        if (!isset($_GET['id'])) {
            echo $form->field($model, 'tpt_tp_nikes')->widget(Select2::classname(), [
                'options' => ['multiple'=>false, 'placeholder' => 'Ketik Nikes ...'],
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
        
            <?= $form->field($model, 'nama_peserta')->textInput()->textInput(['readonly' => true]) ?>
        
            <?= $form->field($model, 'nama_pegawai')->textInput()->textInput(['readonly' => true]) ?>
        
            <?= $form->field($model, 'rekmedis')->dropDownList(
                ArrayHelper::map(Pendaftaran::find()->select(['td_id', 'td_rekam_medis'])->all(), 'td_id', 'td_rekam_medis'), 
                ['prompt'=>'Pilih Rekam Medis...','onchange'=>'tujuanDaftar(this.value);','disabled'=>true])->label('Nomor Rekam Medis') ?>
        
            <?= $form->field($model, 'tujuan')->textInput(['readonly' => true]) ?>
        
            <?= $form->field($model, 'tpt_td_id')->textInput(['readonly' => true]) ?>
    
        <?php if (isset($_GET['uniq_code']) || $diagnosa !='') { 
        ?>
           <?php 
                echo $form->field($model, 'tpt_diagnosa')->widget(Select2::classname(), [
                    'initValueText' => $diagnosa,
                    'value' => $model->tpt_diagnosa,
                    'options' => ['multiple'=>false, 'placeholder' => 'Ketik Diagnosa ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax' => [
                            'url' => $url2,
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(city) { return city.text; }'),
                        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    ],
                ]);
            ?>
        <?php
        }else{
        ?>
        <?php 
            echo $form->field($model, 'tpt_diagnosa')->widget(Select2::classname(), [
                'options' => ['multiple'=>false, 'placeholder' => 'Ketik Diagnosa ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => $url2,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]);
        ?>
        <?php } ?>
            <?= $form->field($model, 'tpt_path_permintaan_tindak')->widget(FileInput::classname(), [
              // 'options' => ['accept' => 'doc/*'],
               'pluginOptions' => [
                    'width'=> '90%',
                    // 'allowedFileExtensions'=>['txt','csv'],
                    'showPreview' => true,
                    'showCaption' => true,
                    'showRemove' => true,
                    'showCancel' => false,
                    'showUpload' => false,
                ]
          ])->label('Upload File Permintaan Tindak');?>
        
       <!--  <div class="col-md-8">
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

            <?= $form->field($model, 'tpt_catatan_mitra')->textArea() ?>
            <?= $form->field($model, 'tpt_uniq_code')->hiddenInput(['readonly' => true])->label(false) ?>
            <?= $form->field($model, 'biaya')->textInput() ?>
        
        <div class="col-md-8 form-group">
            <?= ($model->tpt_flag_status=='')?Html::submitButton('Submit', ['class' => 'btn btn-success']):''; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    var rupiah = document.getElementById('persetujuan-biaya');
    $( document ).ready(function() {
        var rupiah = document.getElementById('persetujuan-biaya');
        daftarData($('#persetujuan-tpt_tp_nikes').val());
        if (rupiah!='') {
            rupiah.value = formatRupiah(rupiah.value, '');
        }
    });

    rupiah.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        rupiah.value = formatRupiah(this.value, '');
    });

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        rupiah          = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
     
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
     
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }

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
            url: '<?= Url::to(["billing-sementara/daftar"]) ?>'+'&nikes='+val+'&newrecord='+<?= ($model->isNewRecord)?'true':'false'; ?>+'&td_id='+<?= $model->tpt_td_id ?>,  
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
