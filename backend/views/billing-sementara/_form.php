<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\BillingSementara */
/* @var $form yii\widgets\ActiveForm */
$url = Url::to(['pendaftaran/select']);
?>

<div class="billing-sementara-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'tbs_tp_nikes')->textInput()->textInput(['readonly' => true]) ?>
       	</div>

        <div class="col-md-8">
            <?= $form->field($model, 'peserta')->textInput()->textInput(['readonly' => true])->label('Peserta') ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'pegawai')->textInput()->textInput(['readonly' => true])->label('Pegawai') ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'hakkelas')->textInput()->textInput(['readonly' => true])->label('Hak Kelas') ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'jenis_peserta')->textInput()->textInput(['readonly' => true])->label('Kategori Peserta') ?>
        </div>

        <div class="col-md-8">
    		<?= $form->field($model, 'tbs_td_id')->textInput()->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-8">
    		<?= $form->field($model, 'rekmed')->textInput()->textInput(['readonly' => true])->label("Rekam Medis") ?>
        </div>
        <div class="col-md-8">
    		<?= $form->field($model, 'tujuan')->textInput()->textInput(['readonly' => true]) ?>
        </div>

        <!-- <div class="col-md-12"> -->
            <div class="col-md-5">
            <?php 
            $realpath=$model->tbs_path_billing;
                $petjah = explode('/', $model->tbs_path_billing);
                $model->tbs_path_billing = $petjah[count($petjah)-1];
            ?>
            <?= $form->field($model, 'tbs_path_billing')->textInput(['disabled' => true])->label('File Permintaan Tindak') ?>
            </div>
             <div class="col-md-1" style="padding-top: 25px">
                <?= Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$realpath]), ['class' => 'btn btn-success', 'target' => '_blank'
                // 'onclick'=>'theFunction("'.Yii::$app->params['downloadPermintaan'].$model->tpt_path_permintaan_tindak.'"); return false;',
                ]) ?>
            </div>
            <div class="col-md-2" style="padding-top: 25px">
                <?= Html::a('Download File',Url::to(['persetujuan/download','filename'=>$realpath]), ['class' => 'btn btn-success', 'target' => '_blank'
                // 'onclick'=>'theFunction("'.Yii::$app->params['downloadPermintaan'].$model->tpt_path_permintaan_tindak.'"); return false;',
                ]) ?>
            </div>
        <!-- </div> -->

        <div class="col-md-8">
    		<?= $form->field($model, 'tbs_nama_mitra')->textInput()->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tbs_biaya')->textInput()->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tbs_catatan_mitra')->textArea(['readonly' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tbs_flag_status')->dropDownList(
                Yii::$app->params['persetujuanBilling'], 
                ['prompt'=>'Pilih Keputusan...'])->label('Keputusan');
            ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tbs_catatan_yakes')->textArea() ?>
        </div>
        <!-- 

    <?= $form->field($model, 'tbs_flag_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbs_id_user_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbs_catatan_yakes')->textInput() ?>

    <?= $form->field($model, 'tbs_id_user_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbs_nama_mitra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tbs_nama_user_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_billing')->textInput() ?>

    <?= $form->field($model, 'tgl_billing_diresponse')->textInput() ?>

    <?= $form->field($model, 'first_ip_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_ip_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_ip_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_ip_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_date_backend')->textInput() ?>

    <?= $form->field($model, 'last_date_backend')->textInput() ?>

    <?= $form->field($model, 'first_date_frontend')->textInput() ?>

    <?= $form->field($model, 'last_date_frontend')->textInput() ?>

    <?= $form->field($model, 'first_user_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_user_backend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_user_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_user_frontend')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flag_deleted')->textInput() ?> -->

    <div class="col-md-8 form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
   </div>
    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    var rupiah = document.getElementById('billingsementara-tbs_biaya');
    $( document ).ready(function() {
        var rupiah = document.getElementById('billingsementara-tbs_biaya');
        daftarData($('#billingsementara-tbs_tp_nikes').val());
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
	function daftarData(val) {
		$.ajax({
            url: '<?= Url::to(["billing-sementara/daftar"]) ?>'+'&nikes='+val+'&td_id='+<?= $model['tbs_td_id'] ?>, 
            success: function(result){
            	var obj = eval('(' + result + ')');
                $('#billingsementara-tbs_td_id').val(obj.td_id);
                $('#billingsementara-rekmed').val(obj.td_rekam_medis);
                if (obj.td_tujuan==0) {
                	obj.td_tujuan='Rawat jalan';
                }else{
                	obj.td_tujuan='Rawat Inap';
                }
                $('#billingsementara-tujuan').val(obj.td_tujuan);
                $('#billingsementara-peserta').val(obj.td_nama_kel);
                $('#billingsementara-pegawai').val(obj.td_tp_nama_kk);
                $('#billingsementara-hakkelas').val(obj.td_hak_kelas);
                $('#billingsementara-jenis_peserta').val(obj.jenis_peserta);
            }
        });
	}

    function theFunction(id){
        // alert(id);
        window.open(id, '_blank');
        return false;
    }
</script>