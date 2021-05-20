<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Peserta;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model frontend\models\Pendaftaran */
/* @var $form yii\widgets\ActiveForm */
$quer = 'SELECT value FROM `tbl_global_parameter` WHERE name="'.$model->td_mitra.'" ';
$exec = Yii::$app->db->createCommand($quer)->queryAll();
$session = Yii::$app->session;
$pens = $session->get('pens');
$host = $session->get('host');
$band = $session->get('band');
$tanggungan = $session->get('tanggungan');
$golongan = $session->get('golongan');
$jenis_peserta = $session->get('jenis_peserta');
?>

<div class="pendaftaran-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-8">
        <?= $form->field($model, 'td_tp_nikes')->textInput(['maxlength' => true,'readonly' => true]) ?>
        </div>
        <div class="col-md-8" style="display: none;">
        <?= $form->field($model, 'td_tp_id')->dropDownList(
            ArrayHelper::map(Peserta::find()->select(['tp_id', 'tp_nama_kk'])->all(), 'tp_id', 'tp_nama_kk'), 
            ['prompt'=>'Pilih Peserta...']); ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_rekam_medis')->textInput(['maxlength' => true,'readonly' => true]) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_tujuan')->dropDownList(
            [0=>'Rawat Jalan', 1=>'Rawat Inap'], 
            ['prompt'=>'Pilih Tujuan...','disabled'=>'disabled']); ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_tp_nik')->textInput(['maxlength' => true,'readonly' => true]) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_umur')->textInput(['maxlength' => true,'readonly' => true]) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_tp_nama_kk')->textInput(['maxlength' => true,'readonly' => true]) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_tp_no_bpjs')->textInput(['maxlength' => true,'readonly' => true]) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_tp_band_posisi')->dropDownList(
            ArrayHelper::map($band, 'tbp_id', 'tbp_penamaan'), 
            ['prompt'=>'','disabled'=>true,'id'=>'dropdownKategori1']); ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_tp_jenis_peserta')->dropDownList(
            ArrayHelper::map($jenis_peserta, 'tjp_id', 'tjp_penamaan'), 
            ['prompt'=>'','disabled'=>true,'id'=>'dropdownKategori2'])->label('Klinik Faskes'); ?>
        </div>
        <!-- <div class="col-md-8">
            <?= $form->field($model, 'kategori_peserta')->dropDownList(
            [''=>'',1=>'Pensiun',2=>'Pegawai'], 
            ['disabled'=>true,'id'=>'dropdownKategori']); ?>
        </div> -->
        <div class="col-md-8">
        <?= $form->field($model, 'td_mitra')->textInput(['maxlength' => true,'readonly'=>true]) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_path_rujukan')->textInput(['maxlength' => true,'readonly'=>true]) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_hak_kelas')->dropDownList(
            ArrayHelper::map($exec, 'value', 'value')); ?>
        </div>
        <!-- <div class="col-md-8">
        <?= $form->field($model, 'td_flag_status')->textInput() ?>
        </div> -->
        <div class="col-md-8 form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
        </div>
    </div>  
    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $( document ).ready(function() {
        if (<?= $model->td_flag_status ?> >= 5) {
            alert('Pendaftaran ini sudah billing final.');
            $('#pendaftaran-td_tp_nikes').val('');
        }else{
            updateAll($('#pendaftaran-td_tp_nikes').val());
        }
    });
    function updateAll(value) {
        $.ajax({
            url: '<?= Url::to(["pendaftaran/peserta"]) ?>'+'&td_tp_nikes='+value, 
            success: function(result){
                result = eval('(' + result + ')');
                $('#pendaftaran-td_tp_nik').val(result.tp_nik);
                $('#pendaftaran-td_umur').val(getYears(result.tp_tgl_lahir));
                $('#pendaftaran-td_tp_nama_kk').val(result.tp_nama_kk);
                $('#pendaftaran-td_tp_no_bpjs').val(result.tp_no_bpjs);
                $('#pendaftaran-td_tp_band_posisi').val(result.tp_band_posisi);
                $('#pendaftaran-td_tp_jenis_peserta').val(result.tp_jenis_peserta);
            }
        });
    }
    function getYears(from) {
        var date1 = new Date(from);
        var date2 = new Date('<?= date("Y-m-d")?>');
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000*60*60*24)); 
        umur = diffDays/365;
        // if (umur.search('.')>0) {
        //     umur = umur.split('.');
        //     return umur[0];   
        // }else{
            return Math.round(umur);
        // }
    }
</script>