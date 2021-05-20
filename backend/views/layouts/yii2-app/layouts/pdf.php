<?php 
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use kartik\date\DatePicker;
    use yii\widgets\ActiveForm;
    use kartik\select2\Select2;
    use yii\web\JsExpression;
    use backend\models\Rujukan;

    /* @var $this yii\web\View */
    /* @var $model frontend\models\Rujukan */
    /* @var $form yii\widgets\ActiveForm */
    $url2 = Url::to(['diagnosa']);
    $model = Rujukan::findOne($_GET['id']);
    if ($model->tr_td_id!='') {
        $_GET['td_id'] = $model->tr_td_id;
    }
    $d = date('d',strtotime($model->tr_tgl_rujukan));
    $m = Yii::$app->params['array_bulan'][date('m',strtotime($model->tr_tgl_rujukan))];
    $y = date('Y',strtotime($model->tr_tgl_rujukan));
    $model->tr_tgl_rujukan = ' '.$d.' '.$m.' '.$y;

    $dique = 'select tdg_penamaan from tbl_diagnosa where tdg_id="'.$model->tr_diagnosa.'"';
    $model->tr_diagnosa = Yii::$app->db->createCommand($dique)->queryScalar();

    $kategori_host = 'select kategori_host from tbl_peserta where tp_nikes="'.$model->tr_nikes.'"';
    $model->kategori_host = Yii::$app->db->createCommand($kategori_host)->queryScalar();

    $kategori_host = 'select kategori_host from tbl_peserta where tp_nikes="'.$model->tr_nikes.'"';
    $model->kategori_host = Yii::$app->db->createCommand($kategori_host)->queryScalar();

    if ($model->kategori_host==1) {
        $band = 'select tbp_grade from tbl_band_posisi where tbp_id="'.$model->tr_band.'"';
        $model->tr_band = Yii::$app->db->createCommand($band)->queryScalar();
    }else{
        $band = 'select tbp_penamaan from tbl_band_posisi where tbp_id="'.$model->tr_band.'"';
        $model->tr_band = Yii::$app->db->createCommand($band)->queryScalar();
    }
    // echo "<pre>"; print_r(Yii::$app->params['kategori_host']);echo "</pre>";

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <style src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"></style>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.min.css'>
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="css/chat.css" rel="stylesheet">
    <body>
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <style type="text/css">
            body {
                /*background-color: #FFFFFF;*/
            }
            .rujukan-div{
                /*background-color: #4de54d;*/
                /*background-color: #FFFFFF;*/
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
                /*margin-top: 1%;*/
            }
            .rujukan-divcontainer{
                border: 1px solid #ccc;
                margin-bottom: 20px;
            }
            .form-control[readonly]{
                cursor: not-allowed;
            }
            .tikom{
                width: 5px;
                padding-right: 0px;
            }
            .col-xs-5 {
                float: none;
            }
        </style>
        <div class="rujukan-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-xs-12 rujukan-div">
                <div class="control-label rujukan-divchild">
                    <img src="image\logoyakes.png" width="250px" style="margin-right: 751px; margin-bottom: -30px;">
                    <label class="control-label text-left">No. Registrasi </label><label class="">: <?= $model->tr_no_regis ?></label><br>

                    <label style="margin-right: 1005px;"></label><label class="control-label text-left" style="margin-top: -10px">No. Rujukan </label><label class="">: <?= $model->tr_no_rujukan ?></label><br>
                </div>
            </div>
            <div class="col-xs-12 rujukan-div">
                <div class="col-xs-6">
                    <label style="font-size: 20px;margin-top: 30px">Surat Rujukan Rawat Inap</label>
                </div>
            </div>
            <div class="col-xs-12 rujukan-divcontainer">
                <div class="col-xs-8 rujukan-divchild" >
                    <label class="control-label col-xs-4 text-left">Tujuan </label><label class="col-xs-1 tikom">:</label><label class="col-xs-5"> <?= $model->tr_tujuan ?></label><br>
                    <label class="control-label col-xs-4 text-left">Nama Dokter </label><label class="col-xs-1 tikom">:</label><label class="col-xs-5"> <?= $model->tr_nama_dokter ?></label><br>
                </div>
                <div class="col-xs-12 rujukan-divchild">
                    <label>Bersama ini kami mohon untuk pemeriksaan dan atau pengobatan dari :</label>
                </div>
                <div class="col-xs-12 rujukan-divchild"">
                    <label class="control-label col-xs-4 text-left">Nama Pasien </label><label class="col-xs-1 tikom">:</label><label class="col-xs-5"> <?= $model->tr_nama_pasien ?></label><br>
                    <label class="control-label col-xs-4 text-left">Umur </label><label class="col-xs-1 tikom">:</label><label class="col-xs-5"> <?= $model->tr_umur ?></label><br>
                    <label class="control-label col-xs-4 text-left">Nikes </label><label class="col-xs-1 tikom">:</label><label class="col-xs-5"> <?= $model->tr_nikes ?></label><br>
                    <label class="control-label col-xs-4 text-left">Nama Kepala Keluarga </label><label class="col-xs-1 tikom">:</label><label class="col-xs-5"> <?= $model->tr_nama_kk ?></label><br>
                    <label class="control-label col-xs-4 text-left">Band </label><label class="col-xs-1 tikom">:</label><label class="col-xs-5"> <?= $model->tr_band ?></label><br>
                    <label class="control-label col-xs-4 text-left">Kategori Host </label><label class="col-xs-1 tikom">:</label><label class="col-xs-5"> <?= Yii::$app->params['kategori_host'][$model->kategori_host] ?></label><br>
                    <label class="control-label col-xs-4 text-left">Hak Kelas Perawatan </label><label class="col-xs-1 tikom">:</label><label class="col-xs-5"> <?= $model->tr_hak_kelas ?></label><br>
                    <label class="control-label col-xs-4 text-left">Anamnese </label><label class="col-xs-1 tikom">:</label><label class="col-xs-6"> <?= $model->tr_anamnese ?></label><br>
                    <label class="control-label col-xs-4 text-left">Diagnosa </label><label class="col-xs-1 tikom">:</label><label class="col-xs-6"> <?= $model->tr_diagnosa ?></label><br>
                    <label class="control-label col-xs-4 text-left">Terapi & Tindakan yang telah diberikan </label><label class="col-xs-1 tikom">:</label><label class="col-xs-6"> <?= $model->tr_tindakan ?></label><br>
                    <label class="control-label col-xs-4 text-left">Nama Pemberi Penjamin </label><label class="col-xs-1 tikom">:</label><label class="col-xs-5"> <?= $model->tr_nama_jaminan ?></label><br>
                </div>
                <div class="col-xs-12 rujukan-divtgl">
                    <label class="control-label col-xs-4 text-left">Surat rujukan mulai berlaku dari tgl </label><label class='col-xs-2' style='margin-left: -70px;'>: <?= $model->tr_tgl_rujukan ?></label><span style='font-style: italic;margin-left: -30px;'>*tgl masuk rs</span><br>
                </div>
                <div class="col-xs-12 rujukan-divttd">
                    <div class="col-xs-8">
                    </div>
                    <div class="col-xs-4" style="text-align: center;">
                        <label>Jakarta Pusat, </label><label id="tgl_rujukan"><?= $model->tr_tgl_rujukan ?></label><br>
                        <label>Teman Sejawat,</label><br><br><br><br>
                        <label id="nama_penjamin"><?= $model->tr_nama_jaminan ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <?php ActiveForm::end(); ?>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
