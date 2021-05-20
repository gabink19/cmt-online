<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker

/* @var $this yii\web\View */
/* @var $model frontend\models\Peserta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="peserta-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'tp_nik')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_nama_kk')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_nikes')->textInput(['maxlength' => true,'onkeyup'=>'getStatusKel();']) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_status_kel')->textInput(['maxlength' => true,'readonly'=>true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_nama_kel')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_hr_pens')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_hr_host')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
             <?= $form->field($model, 'tp_band_posisi')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= '<label class="control-label">Tgl Lahir</label>' ?>
            <?= DatePicker::widget([
                'id' => 'tp_tgl_lahir', 
                'name' => 'Peserta[tp_tgl_lahir]', 
                'attribute' => 'tp_tgl_lahir', 
                'value' => ($model->tp_tgl_lahir!='')?$model->tp_tgl_lahir:date('Y-m-d', strtotime('-10 years')),
                'options' => ['placeholder' => 'Pilih Tanggal Lahir ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true
                ]
            ]);?>
        </div>
        <br>

        <div class="col-md-5">
            <?= $form->field($model, 'tp_umur')->textInput(['maxlength' => true,'readonly'=>true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_gol')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_tanggungan')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= '<label class="control-label">Tgl Pensiun</label>' ?>
            <?= DatePicker::widget([
                'id' => 'tp_tgl_pens', 
                'name' => 'Peserta[tp_tgl_pens]', 
                'attribute' => 'tp_tgl_pens', 
                'value' => ($model->tp_tgl_pens!='')?$model->tp_tgl_pens:'',
                'options' => ['placeholder' => 'Pilih Tanggal ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true
                ]
            ]);?>
        </div>
        <div class="col-md-8">
            <?= '<label class="control-label">Tgl Akhir Tanggungan</label>' ?>
            <?= DatePicker::widget([
                'id' => 'tp_tgl_akhir_tanggunngan', 
                'name' => 'Peserta[tp_tgl_akhir_tanggunngan]', 
                'attribute' => 'tp_tgl_akhir_tanggunngan', 
                'value' => ($model->tp_tgl_akhir_tanggunngan!='')?$model->tp_tgl_akhir_tanggunngan:'',
                'options' => ['placeholder' => 'Pilih Tanggal ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true
                ]
            ]);?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_jenis_peserta')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_jenis_kelamin')->dropDownList(
                [0=>'Laki-Laki',1=>'Perempuan'], 
                ['prompt'=>'Pilih Jenis Kelamin...']);
            ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_no_bpjs')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_no_telp')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'tp_flag_active')->dropDownList(
                [0=>'Masih Hidup',1=>'Sudah Meninggal'], 
                ['prompt'=>'Pilih Status...']);
            ?>
        </div>
        <div class="col-md-8 form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
        </div>

        
    </div>
    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    $( document ).ready(function() {
        hitung = getYears("'"+$('#tp_tgl_lahir').val()+"'", '<?=date('Y-m-d')?>');
        $('#peserta-tp_umur').val(hitung+" Tahun");
        $('#tp_tgl_lahir').on('change', function() {
            hitung = getYears("'"+$(this).val()+"'", '<?=date('Y-m-d')?>');
            $('#peserta-tp_umur').val(hitung+" Tahun");
        });
        getStatusKel();
    });

    function getYears(from, to) {
        var date1 = new Date(from);
        var date2 = new Date(to);
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
    function getStatusKel() {
        var id = $('#peserta-tp_nikes').val()
        var lastFive = id.substr(id.length - 3); // => "Tabs1"
        $('#peserta-tp_status_kel').val(lastFive);
    }

</script>