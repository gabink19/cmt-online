<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\Billingfinal */
/* @var $form yii\widgets\ActiveForm */
$url = Url::to(['pendaftaran/select']);
$url2 = Url::to(['persetujuan-baru/diagnosa']);
$model->tbs_nama_mitra = Yii::$app->user->identity->rs_mitra;
if ($model->tbs_td_id=='') {
    $q = 'SELECT tpt_diagnosa FROM tbl_persetujuan_tindak WHERE tpt_td_id="'.$model->tbs_td_id.'"';
    $model->tbs_diagnosa = Yii::$app->db->createCommand($q)->queryScalar();
}

$q = 'select tdg_penamaan from tbl_diagnosa where tdg_id="'.$model->tbs_diagnosa.'"';
$d = Yii::$app->db->createCommand($q)->queryScalar();
$diagnosa = $d;
// echo "<pre>"; print_r($q);echo "</pre>";die();
?>

<div class="billing-final-form">

    <?php $form = ActiveForm::begin(['options' => ['onsubmit'=>"return confirm('Pastikan anda sudah mengupdate diagnosa final pasien & biaya final pasien ?');"]]); ?>
	<div class="row">
        <div class="col-md-8">
            <?php 
            // echo $form->field($model, 'tpt_tp_nikes')->dropDownList(
                // ArrayHelper::map(Peserta::find()->select(['tp_nikes', 'tp_nikes'])->all(), 'tp_nikes', 'tp_nikes'), 
                // ['prompt'=>'Pilih Peserta...','onchange'=>'rekemed(this.value);']); ?>

            <?php
            if (!isset($_GET['id'])) {
                echo $form->field($model, 'tbs_tp_nikes')->widget(Select2::classname(), [
                'data' =>[],
                'options' => ['placeholder' => 'Ketikan Nikes ...','onchange'=>'daftarData(this.value);'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Sedang mencari...'; }"),
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
            echo $form->field($model, 'tbs_tp_nikes')->textInput()->textInput(['readonly' => true]);
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
    		<?= $form->field($model, 'tbs_td_id')->textInput()->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-8">
    		<?= $form->field($model, 'rekmed')->textInput()->textInput(['readonly' => true])->label("Rekam Medis") ?>
        </div>
        <div class="col-md-8">
    		<?= $form->field($model, 'tujuan')->textInput()->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-md-8">
        <?php 
            echo $form->field($model, 'tbs_diagnosa')->widget(Select2::classname(), [
                'initValueText' => $diagnosa,
                'value' => $model->tbs_diagnosa,
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
        </div>

        <div class="col-md-8">
            <?= $form->field($model, 'tbs_path_billing')->widget(FileInput::classname(), [
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
          ])->label('Upload File Billing');?>
        </div>

        <div class="col-md-8">
            <?= $form->field($model, 'tbs_path_resume')->widget(FileInput::classname(), [
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
          ])->label('Upload File Resume');?>
        </div>
        <div class="col-md-8">
    		<?= $form->field($model, 'tbs_nama_mitra')->textInput()->textInput(['readonly' => true]) ?>
        </div>

        <div class="col-md-8">
            <?= $form->field($model, 'tbs_biaya')->textInput() ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tbs_catatan_mitra')->textArea() ?>
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
    var rupiah = document.getElementById('billingfinal-tbs_biaya');
    $( document ).ready(function() {
        var rupiah = document.getElementById('billingfinal-tbs_biaya');
        daftarData($('#billingfinal-tbs_tp_nikes').val());
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
            url: '<?= Url::to(["billing-sementara/daftar"]) ?>'+'&nikes='+val+'&newrecord='+<?= ($model->isNewRecord)?'true':'false'; ?>+'&td_id='+<?= $model->tbs_td_id ?> ,  
            success: function(result){
                if (result==100) {
                    alert('Daftar dengan Nikes tersebut tidak ditemukan.');
                    $('#billingfinal-tbs_tp_nikes').val('').trigger('change');
                    return false;
                }
                
                if (result==101) {
                    alert('Nikes tersebut telah membuat billing final.');
                    $('#billingfinal-tbs_tp_nikes').val('').trigger('change');
                    return false;
                }
            	var obj = eval('(' + result + ')');
                $('#billingfinal-tbs_td_id').val(obj.td_id);
                $('#billingfinal-rekmed').val(obj.td_rekam_medis);
                if (obj.td_tujuan==0) {
                	obj.td_tujuan='Rawat jalan';
                }else{
                	obj.td_tujuan='Rawat Inap';
                }
                $('#billingfinal-tujuan').val(obj.td_tujuan);
                $('#billingfinal-nama_pegawai').val(obj.td_tp_nama_kk);
                $('#billingfinal-nama_peserta').val(obj.td_nama_kel);
            }
        });
	}
</script>