<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Peserta;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use common\models\LoginForm;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model frontend\models\Pendaftaran */
/* @var $form yii\widgets\ActiveForm */
$session = Yii::$app->session;
$user = $session->get('user');
$model->td_mitra = $user->rs_mitra;

$session = Yii::$app->session;
$pens = $session->get('pens');
$host = $session->get('host');
$band = $session->get('band');
$tanggungan = $session->get('tanggungan');
$golongan = $session->get('golongan');
$jenis_peserta = $session->get('jenis_peserta');
$url = Url::to(['select']);
?>

<div class="pendaftaran-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-8">
        <?php 
        if (!isset($_GET['id'])) {
            echo $form->field($model, 'td_tp_nikes')->widget(Select2::classname(), [
                'options' => ['multiple'=>false, 'placeholder' => 'Ketik Nikes ...', 'onchange'=>'updateAll(this.value);'],
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
            echo $form->field($model, 'td_tp_nikes')->textInput(['maxlength' => true,'readonly' => true]) ;
        }
        ?>
        </div>
        <div class="col-md-8" style="display: none;">
        <?= $form->field($model, 'td_tp_id')->dropDownList(
            /*ArrayHelper::map(Peserta::find()->select(['tp_id', 'tp_nama_kk'])->all(), 'tp_id', 'tp_nama_kk')*/[], 
            ['prompt'=>'Pilih Peserta...']); ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_rekam_medis')->textInput(['maxlength' => true])->label('Rekam Medis (Di isi dari rumah sakit.)') ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_tujuan')->dropDownList(
            Yii::$app->params['tujuan'], 
            ['prompt'=>'Pilih Tujuan...','onchange'=>'change_label(this.value)']); ?>
        </div>
        <div class="col-md-8" id="tanggal" style="display: none;">
            <?= $form->field($model, 'td_tgl_daftar')->widget(DatePicker::classname(), [
                'id' => 'td_tgl_daftar', 
                'name' => 'Pendaftaran[td_tgl_daftar]', 
                'attribute' => 'td_tgl_daftar', 
                'value' => ($model->td_tgl_daftar!='')?$model->td_tgl_daftar:date('Y-m-d', strtotime('-10 years')),
                'options' => ['placeholder' => 'Pilih Tanggal ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'autoclose' => true
                ]
            ]);?>
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
        <?= $form->field($model, 'td_nama_kel')->textInput(['maxlength' => true,'readonly' => true]) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_tp_no_bpjs')->textInput(['maxlength' => true,'readonly' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'td_tp_band_posisi')->dropDownList(
            ArrayHelper::map($band, 'tbp_id', 'tbp_penamaan'), 
            ['prompt'=>'','disabled'=>true,'id'=>'dropdownKategori1']); ?>
        <?= $form->field($model, 'td_tp_band_posisi')->hiddenInput(['maxlength' => true,'readonly' => true])->label(false) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'td_tp_jenis_peserta')->dropDownList(
            ArrayHelper::map($jenis_peserta, 'tjp_id', 'tjp_penamaan'), 
            ['prompt'=>'','disabled'=>true,'id'=>'dropdownKategori2'])->label('Klinik Faskes'); ?>
        <?= $form->field($model, 'td_tp_jenis_peserta')->hiddenInput(['maxlength' => true,'readonly' => true])->label(false) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'kategori_peserta')->dropDownList(
            [''=>'',1=>'Pensiun',2=>'Pegawai'], 
            ['disabled'=>true,'id'=>'dropdownKategori']); ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_mitra')->textInput(['maxlength' => true,'readonly' => true]) ?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_path_rujukan')->widget(FileInput::classname(), [
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
          ])->label('Upload File');?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_path_rujukan_2')->widget(FileInput::classname(), [
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
          ])->label('Upload File');?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_path_rujukan_3')->widget(FileInput::classname(), [
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
          ])->label('Upload File');?>
        </div>
        <div class="col-md-8">
        <?= $form->field($model, 'td_hak_kelas')->textInput(['maxlength' => true,'readonly'=>true]) ?>
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
    <?php 
        if (isset($_GET['id'])) {
            echo "$( document ).ready(function() {
                    updateAll($('#pendaftaran-td_tp_nikes').val());
                    change_label($('#pendaftaran-td_tujuan').val());
                });";
        }
    ?>
    function change_label(val) {
        if (val==1) {
            $("label[for='pendaftaran-td_path_rujukan']").text('Upload File Surat Keterangan Rawat')
            $("label[for='pendaftaran-td_path_rujukan_2']").text('Upload File Surat Keterangan Rawat')
            $("label[for='pendaftaran-td_path_rujukan_3']").text('Upload File Surat Keterangan Rawat')
             $("#tanggal").hide();
        }else if (val==0){
             $("label[for='pendaftaran-td_path_rujukan']").text('Upload File Rujukan Jalan')
             $("label[for='pendaftaran-td_path_rujukan_2']").text('Upload File Rujukan Jalan')
             $("label[for='pendaftaran-td_path_rujukan_3']").text('Upload File Rujukan Jalan')
             $("#tanggal").hide();
        }else if (val==2){
             $("label[for='pendaftaran-td_path_rujukan']").text('Upload File Preadmision')
             $("label[for='pendaftaran-td_path_rujukan_2']").text('Upload File Preadmision')
             $("label[for='pendaftaran-td_path_rujukan_3']").text('Upload File Preadmision')
             $("#tanggal").show();
        }else if (val==3){
             $("label[for='pendaftaran-td_path_rujukan']").text('Upload File IGD')
             $("label[for='pendaftaran-td_path_rujukan_2']").text('Upload File IGD')
             $("label[for='pendaftaran-td_path_rujukan_3']").text('Upload File IGD')
             $("#tanggal").hide();
        }
    }
    function updateAll(value) {
        $.ajax({
            url: '<?= Url::to(["pendaftaran/peserta"]) ?>'+'&td_tp_nikes='+value, 
            success: function(result){
                result = eval('(' + result + ')');
                $('#pendaftaran-td_tp_nik').val(result.tp_nik);
                $('#pendaftaran-td_umur').val(getYears(result.tp_tgl_lahir));
                $('#pendaftaran-td_tp_nama_kk').val(result.tp_nama_kk);
                $('#pendaftaran-td_nama_kel').val(result.tp_nama_kel);
                $('#pendaftaran-td_tp_no_bpjs').val(result.tp_no_bpjs);
                $('#pendaftaran-td_tp_band_posisi').val(result.tp_band_posisi);
                $('#dropdownKategori1').val(result.tp_band_posisi);
                $('#pendaftaran-td_tp_jenis_peserta').val(result.tp_jenis_peserta);
                $('#dropdownKategori2').val(result.tp_jenis_peserta);
                $('#pendaftaran-td_hak_kelas').val(result.hak_kelas);
                $('#dropdownKategori').val(result.kategori_host);
                
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