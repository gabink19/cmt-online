<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\Rujukan */
/* @var $form yii\widgets\ActiveForm */
$url2 = Url::to(['diagnosa']);
?>
<link href="loading.css" rel="stylesheet">
<style type="text/css">
    .rujukan-div{
        /*background-color: #4de54d;*/
    }
    .rujukan-divchild{
        margin-top: 20px;
    }
    .rujukan-divttd{
        margin-top: 20px;
        text-align: right;
    }
    .rujukan-divtgl{
        margin-top: 50px;
        margin-left: -20px;
    }
    .form-control {
        height: 30px;
        margin-bottom: 5px;
    }
    .control-label{
        margin-top: 1%;
    }
    .rujukan-divcontainer{
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }
    .form-control[readonly]{
        cursor: not-allowed;
    }
</style>
<div class="rujukan-form">
<div id='loading-wrapper' style="display: block;">
  <div id='loading-text'>LOADING</div>
  <div id='loading-content'></div>
</div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12 rujukan-div">
        <div class="col-md-6 rujukan-divchild">
            <img src="image\logoyakes.png" width="250px">
        </div>
        <div class="col-md-6 rujukan-divchild">
            <?= $form->field($model, 'tr_no_regis',[
                                            'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                        ])->textInput(['maxlength' => true])
                                        ->label("No. Registrasi",['class' => 'control-label col-xs-4 text-left']);?>
            <?= $form->field($model, 'tr_no_rujukan',[
                                            'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                        ])->textInput(['maxlength' => true])
                                        ->label("No. Rujukan",['class' => 'control-label col-xs-4 text-left']);?>
        </div>
        <div class="col-md-6">
            <label style="font-size: 20px">Surat Rujukan Rawat Inap</label>
        </div>
        <div class="col-md-12 rujukan-divcontainer">
            <div class="col-md-8"><!-- 
                <?= $form->field($model, 'tr_tujuan',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->dropDownList(
                                            Yii::$app->params['tujuan'], 
                                            ['prompt'=>'Pilih Tujuan...','onchange'=>'updatePenjamin(this.value)'])
                                            ->label("Tujuan",['class' => 'control-label col-xs-4 text-left']);?> -->
                <?= $form->field($model, 'tr_tujuan',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true,'readonly'=>true])
                                            ->label("Tujuan",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'tr_nama_dokter',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true])
                                            ->label("Nama Dokter",['class' => 'control-label col-xs-4 text-left']);?>
            </div>
            <div class="col-md-12 rujukan-divchild">
                <label>Bersama ini kami mohon untuk pemeriksaan dan atau pengobatan dari :</label>
            </div>
            <div class="col-md-9">
                <?= $form->field($model, 'tr_nama_pasien',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true,'readonly'=>true])
                                            ->label("Nama Pasien",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'tr_umur',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true,'readonly'=>true])
                                            ->label("Umur",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'tr_nikes',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true,'readonly'=>true])
                                            ->label("Nikes",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'tr_nama_kk',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true,'readonly'=>true])
                                            ->label("Nama Kepala Keluarga",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'tr_band',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true,'readonly'=>true])
                                            ->label("Band",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'kategori_host',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true,'readonly'=>true])
                                            ->label("Kategori Host",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'tr_hak_kelas',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true,'readonly'=>true])
                                            ->label("Hak Kelas Perawatan",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'tr_anamnese',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textArea(['maxlength' => true,'readonly'=>true])
                                            ->label("Anamnese",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'tr_diagnosa',[
                                                'template' => "{label}<div class='col-md-8' style='margin-bottom:10px'> {input}</div>\n{hint}\n{error}"
                                            ])->widget(Select2::classname(), [
                                                'initValueText' => $model->tr_diagnosa,
                                                'value' => $model->tr_diagnosa,
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
                                            ])
                                            ->label("Diagnosa",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'tr_tindakan',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->textArea(['maxlength' => true])
                                            ->label("Terapi & Tindakan yang telah diberikan",['class' => 'control-label col-xs-4 text-left']);?>
                <?= $form->field($model, 'tr_nama_jaminan',[
                                                'template' => "{label}<div class='col-md-8'> {input}</div>\n{hint}\n{error}"
                                            ])->dropDownList(
                                            Yii::$app->params['penjamin'], 
                                            ['prompt'=>'Pilih Penjamin...','onchange'=>'updatePenjamin(this.value)'])->label("Nama Pemberi Penjamin",['class' => 'control-label col-xs-4 text-left']);?>
            </div>
            <div class="col-md-12 rujukan-divtgl">
                <?= $form->field($model, 'tr_tgl_rujukan',[
                                                'template' => "{label}<div class='col-md-3' style='margin-left: -70px;'> {input}</div><span style='font-style: italic;'>*tgl masuk rs</span>\n{hint}\n{error}"
                                            ])->widget(DatePicker::classname(), [
                                                'type' => DatePicker::TYPE_INPUT,
                                                'pluginOptions' => [
                                                    'autoclose'=>true,
                                                    'format' => ' dd MM yyyy'
                                                ],
                                                'options'=>[
                                                    'onchange'=>'updateTanggal(this.value)',
                                                ]
                                            ])
                                            ->label("Surat rujukan mulai berlaku dari tgl ",['class' => 'control-label col-xs-4 text-left']);?>
            </div>

            <?php 
                $model->tr_td_id = $_GET['td_id'];
                echo $form->field($model, 'tr_td_id')->hiddenInput()->label(false) ;
            ?>
            <div class="col-md-12 rujukan-divttd">
                <div class="col-md-8">
                </div>
                <div class="col-md-4" style="text-align: center;">
                    <label>Jakarta Pusat, </label><label id="tgl_rujukan">[Tanggal Rujukan]</label><br>
                    <label>Teman Sejawat,</label><br><br><br><br>
                    <label id="nama_penjamin">[Nama Penjamin]</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-top: 15px">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    <?php 
        if (isset($_GET['td_id'])) {
            echo "$( document ).ready(function() {
                    updateAll($('#pendaftaran-td_tp_nikes').val());
                });";
        }
    ?>
    function updateTanggal(value) {
        if (value=='') {
            $('#tgl_rujukan').text('[Tanggal Rujukan]');
        }else{
            $('#tgl_rujukan').text(value);
        }
    }
    function updatePenjamin(value) {
        if (value=='') {
            $('#nama_penjamin').text('[Nama Penjamin]');
        }else{
            $('#nama_penjamin').text(value);
        }
    }
    function updateAll(value) {
        $.ajax({
            url: '<?= Url::to(["peserta"]) ?>'+'&td_id='+<?= $_GET['td_id']?>, 
            success: function(result){
                result = eval('(' + result + ')');
                $('#rujukan-tr_nama_pasien').val(result.tp_nama_kel);
                $('#rujukan-tr_umur').val(result.tp_umur);
                $('#rujukan-tr_nikes').val(result.tp_nikes);
                $('#rujukan-tr_nama_kk').val(result.tp_nama_kk);
                $('#rujukan-tr_band').val(result.tp_band_posisi);
                $('#rujukan-kategori_host').val(result.kategori_host);
                $('#rujukan-tr_hak_kelas').val(result.hak_kelas);
                $('#rujukan-tr_no_regis').val(result.data_pendaftaran.td_id);
                $('#rujukan-tr_tujuan').val(result.data_pendaftaran.td_tujuan);
                $('#rujukan-tr_hak_kelas').val(result.data_pendaftaran.td_hak_kelas);
                $('#rujukan-tr_anamnese').val(result.data_pendaftaran.anamnese);
                $('#rujukan-tr_no_rujukan').val(result.data_pendaftaran.no_rujukan);
                $('#loading-wrapper').hide();
            }
        });
    }
</script>
