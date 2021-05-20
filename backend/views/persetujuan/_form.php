<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\Peserta;
use frontend\models\Pendaftaran;
use kartik\widgets\DatePicker;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\Persetujuan */
/* @var $form yii\widgets\ActiveForm */
// echo "<pre>"; print_r($_SERVER);echo "</pre>";
?>

<div class="persetujuan-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-12"> 
            <div class="col-md-8">
                <?php // $form->field($model, 'tpt_tp_nikes')->dropDownList(
                    // ArrayHelper::map(Peserta::find()->select(['tp_nikes', 'tp_nikes'])->all(), 'tp_nikes', 'tp_nikes'), 
                    // ['prompt'=>'Pilih Peserta...','disabled'=>true]); ?>

                <?= $form->field($model, 'tpt_tp_nikes')->textInput(['readonly' => true]) ?>
            </div>

        </div>

        <div class="col-md-12"> 
            <div class="col-md-offset-5 col-md-4">
                <?= Html::submitButton('View Riwayat Medis', ['class' => 'btn btn-success','onclick'=>'return false;']) ?>
                <?= Html::a('View Biodata','#', ['class' => 'btn btn-success','onclick'=>'theFunction("/backend/index.php?r=peserta%2Fview&tp_id='.Peserta::find()->select(['tp_id'])->where(['=','tp_nikes', $model->tpt_tp_nikes])->one()->tp_id.'&tp_nikes='.$model->tpt_tp_nikes.'"); return false;',]) ?>
            </div>
        </div>

        <div class="col-md-12"> 
            <div class="col-md-8">
                <?= $form->field($model, 'peserta')->textInput()->textInput(['readonly' => true])->label('Peserta') ?>
            </div>  
        </div>
        <div class="col-md-12"> 
            <div class="col-md-8">
                <?= $form->field($model, 'pegawai')->textInput()->textInput(['readonly' => true])->label('Pegawai') ?>
            </div>
        </div>
        <div class="col-md-12"> 
            <div class="col-md-8">
                <?= $form->field($model, 'hakkelas')->textInput()->textInput(['readonly' => true])->label('Hak Kelas') ?>
            </div>
        </div>
        <div class="col-md-12"> 
            <div class="col-md-8">
                <?= $form->field($model, 'jenis_peserta')->textInput()->textInput(['readonly' => true])->label('Kategori Peserta') ?>
            </div>
        </div>


        <div class="col-md-12"> 
            <div class="col-md-8">
                <?= $form->field($model, 'rekmedis')->dropDownList(
                    ArrayHelper::map(Pendaftaran::find()->select(['td_id', 'td_rekam_medis'])->all(), 'td_id', 'td_rekam_medis'), 
                    ['prompt'=>'Pilih Rekam Medis...','onchange'=>'tujuanDaftar(this.value);','disabled'=>true])->label('Nomor Rekam Medis') ?>
            </div>
        </div>

        <div class="col-md-12"> 
            <div class="col-md-8">
                <?= $form->field($model, 'tujuan')->textInput(['readonly' => true]) ?>
            </div>
        </div>

        <div class="col-md-12"> 
            <div class="col-md-8">
                <?= $form->field($model, 'tpt_td_id')->textInput(['readonly' => true]) ?>
            </div>
        </div>
        <div class="col-md-12"> 
            <div class="col-md-8">
                <?php
                $query = 'SELECT tdg_id as id, tdg_penamaan as nama, tdg_kode as kode FROM tbl_diagnosa WHERE tdg_id='.$model->tpt_diagnosa.' LIMIT 1';
                $command = Yii::$app->db->createCommand($query);
                $data = $command->queryAll();
                foreach ($data as $key => $value) {
                    $model->tpt_diagnosa = $value['kode'] ." - ".$value['nama'];
                }
                ?>
                <?= $form->field($model, 'tpt_diagnosa')->textInput(['disabled' => true]) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-4">
            <?php 
                $realpath = $model->tpt_path_permintaan_tindak;
                $petjah = explode('/', $model->tpt_path_permintaan_tindak);
                $model->tpt_path_permintaan_tindak = $petjah[count($petjah)-1];
            ?>
            <?= $form->field($model, 'tpt_path_permintaan_tindak')->textInput(['disabled' => true])->label('File Permintaan Tindak') ?>
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
        </div>

        <div class="col-md-12"> 
            <div class="col-md-8">
                <?= $form->field($model, 'biaya')->textInput(['readonly' => true]) ?>
            </div>
        </div>

        <div class="col-md-12"> 
            <div class="col-md-8">
                <?= $form->field($model, 'tpt_catatan_mitra')->textArea(['readonly' => true]) ?>
            </div>
        </div>

        <div class="col-md-8">
            <div class="col-md-8">
            <?= $form->field($model, 'tpt_flag_status')->dropDownList(
                Yii::$app->params['persetujuan'], 
                [])->label('Persetujuan');
            ?>
        </div>
        </div>

        <div class="col-md-12"> 
            <div class="col-md-8">
                <?php
                if ($model->biaya_disetujui=='') {
                    $model->biaya_disetujui=$model->biaya;
                }?>
                <?= $form->field($model, 'biaya_disetujui')->textInput() ?>
            </div>
        </div>

        <div class="col-md-12"> 
            <div class="col-md-8">
                <?= $form->field($model, 'tpt_catatan_yakes')->textArea() ?>
            </div>
        </div>

        <div class="col-md-12"> 
            <div class="col-md-8 form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    var rupiah = document.getElementById('persetujuan-biaya_disetujui');
    $( document ).ready(function() {
        var rupiah = document.getElementById('persetujuan-biaya_disetujui');
        tujuanDaftar($('#persetujuan-tpt_td_id').val());
        daftarData($('#persetujuan-tpt_tp_nikes').val());
        var rupiah2 = document.getElementById('persetujuan-biaya');
        if (rupiah!='') {
            rupiah.value = formatRupiah(rupiah.value, '');
        }
        if (rupiah2!='') {
            rupiah2.value = formatRupiah(rupiah2.value, '');
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
    function daftarData(val) {
        $.ajax({
            url: '<?= Url::to(["billing-sementara/daftar"]) ?>'+'&nikes='+val+'&td_id='+<?= $model->tpt_td_id?>, 
            success: function(result){
                var obj = eval('(' + result + ')');
                $('#persetujuan-peserta').val(obj.td_nama_kel);
                $('#persetujuan-pegawai').val(obj.td_tp_nama_kk);
                $('#persetujuan-hakkelas').val(obj.td_hak_kelas);
                $('#persetujuan-jenis_peserta').val(obj.jenis_peserta);
            }
        });
    }
    function theFunction(id){
        // alert(id);
        window.open(id, '_blank');
        return false;
    }
</script>
