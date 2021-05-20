<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\Peserta;
use frontend\models\Pendaftaran;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\Persetujuan */
/* @var $form yii\widgets\ActiveForm */
$url = Url::to(['pendaftaran/select']);
$url2 = Url::to(['diagnosa']);

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
    
        <?php if (isset($_GET['uniq_code'])) { 
        ?>
           <?php 
                echo $form->field($model, 'tpt_diagnosa')->widget(Select2::classname(), [
                    'initValueText' => $model->diagnosa,
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
        

            <?= $form->field($model, 'tpt_catatan_mitra')->textArea() ?>
            <?= $form->field($model, 'tpt_uniq_code')->hiddenInput(['readonly' => true])->label(false) ?>
            <?= $form->field($model, 'biaya')->textInput() ?>
        
        <div class="col-md-8 form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
        </div>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'history_catatan')->textArea(['readonly' => true,'rows'=>"30" ,'cols'=>"50"])->label('History Catatan') ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    var rupiah = document.getElementById('persetujuanbaru-biaya');
    $( document ).ready(function() {
    	var rupiah = document.getElementById('persetujuanbaru-biaya');
        tujuanDaftar($('#persetujuanbaru-tpt_td_id').val());
        daftarData($('#persetujuanbaru-tpt_tp_nikes').val());
        if (rupiah!='') {
            rupiah.value = formatRupiah(rupiah.value, '');
        }
        $('#persetujuanBaru').submit(function() {
            if ($('#persetujuanbaru-tpt_diagnosa').val()=='') {
                alert('Diagnosa tidak boleh kosong.');
                return false;
            }
        })
    });

	rupiah.addEventListener('keyup', function(e){
		// tambahkan 'Rp.' pada saat form di ketik
		// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
		rupiah.value = formatRupiah(this.value, '');
	});

    function formatRupiah(angka, prefix){
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split   		= number_string.split(','),
		sisa     		= split[0].length % 3,
		rupiah     		= split[0].substr(0, sisa),
		ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
	 
		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if(ribuan){
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
	 
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
	}

    function tujuanDaftar(value) {
        $('#persetujuanbaru-tpt_td_id').val(value);
        $('#persetujuanbaru-rekmedis').val(value);
        $.ajax({
            url: '<?= Url::to(["persetujuan/tujuan"]) ?>'+'&id='+value, 
            success: function(result){
                $('#persetujuanbaru-tujuan').val(result);
            }
        });
    }
    function rekemed(value) {
        $.ajax({
            url: '<?= Url::to(["persetujuan/rekmedis"]) ?>'+'&id='+value, 
            success: function(result){
                $('#persetujuanbaru-rekmedis').val(result);
                tujuanDaftar(result);
            }
        });
    }

    function daftarData(val) {
        $.ajax({
            url: '<?= Url::to(["billing-sementara/daftar"]) ?>'+'&nikes='+val+'&newrecord='+<?= ($model->isNewRecord)?'true':'false'; ?>+'&td_id='+<?= $_GET['id'] ?> ,  
            success: function(result){
                if (result==100) {
                    alert('Daftar dengan Nikes tersebut tidak ditemukan.');
                    $('#persetujuanbaru-tpt_tp_nikes').val('').trigger('change');
                    return false;
                }
                
                if (result==101) {
                    alert('Nikes tersebut telah membuat billing final.');
                    $('#persetujuanbaru-tpt_tp_nikes').val('').trigger('change');
                    return false;
                }
                var obj = eval('(' + result + ')');
                $('#persetujuanbaru-nama_pegawai').val(obj.td_tp_nama_kk );
                $('#persetujuanbaru-nama_peserta').val(obj.td_nama_kel);
            }
        });
    }
</script>
