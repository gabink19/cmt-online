<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\Peserta;

/* @var $this yii\web\View */
/* @var $model frontend\models\Pendaftaran */
$nama = @Peserta::findOne($model->td_tp_id)->tp_nama_kel;
$this->title = "Data Pasien ".$nama;
$this->params['breadcrumbs'][] = ['label' => 'Pendaftarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $nama;
\yii\web\YiiAsset::register($this);
?>
<div class="pendaftaran-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'td_tp_nikes',
            [
                'attribute' =>'td_tp_id',
                'value' => function($data){
                    return @Peserta::findOne($data['td_tp_id'])->tp_nama_kel;
                }, 
            ],
            'td_tgl_daftar',
            'td_rekam_medis',
            // 'td_tujuan',
            [
                'attribute' =>'td_tujuan',
                'value' => function($data){
                    return @Yii::$app->params["tujuan"][$data['td_tujuan']];
                }, 
            ],
            'td_tp_nik',
            'td_umur',
            'td_tp_nama_kk',
            'td_nama_kel',
            'td_tp_no_bpjs',
            [
                'attribute' =>'td_tp_band_posisi',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $band = $session->get('band');
                    return @ArrayHelper::map($band, 'tbp_id', 'tbp_penamaan')[$data['td_tp_band_posisi']];
                }, 
            ],
            [
                'attribute' =>'td_tp_jenis_peserta',
                'label'=>'Klinik Faskes',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $jenis_peserta = $session->get('jenis_peserta');
                    return @ArrayHelper::map($jenis_peserta, 'tjp_id', 'tjp_penamaan')[$data['td_tp_jenis_peserta']];
                }, 
            ],
            [
                'attribute' =>'kategori_peserta',
                'value' => function($data){
                    $peserta = Peserta::find()->select(['tp_id'])->where(['=','tp_nikes', $data['td_tp_nikes']])->one();
                    return (@$peserta->kategori_host==1)?'Pensiun':'Pegawai';
                }, 
            ],
            'td_mitra',
            [
                'attribute' =>'td_path_rujukan',
                'format'=>'html',
                'value' => function($data){
                    if ($data['td_path_rujukan']=='') {
                        return '';
                    }
                    return Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$data['td_path_rujukan']]), ['class' => 'btn btn-success', 'target' => '_blank','style'=>'margin-right:2px;']).Html::a('Download File',Url::to(['persetujuan/download','filename'=>$data['td_path_rujukan']]), ['class' => 'btn btn-success', 'target' => '_blank']) ;
                }, 
            ],
            [
                'attribute' =>'td_path_rujukan_2',
                'format'=>'html',
                'value' => function($data){
                    if ($data['td_path_rujukan_2']=='') {
                        return '';
                    }
                    return Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$data['td_path_rujukan_2']]), ['class' => 'btn btn-success', 'target' => '_blank','style'=>'margin-right:2px;']).Html::a('Download File',Url::to(['persetujuan/download','filename'=>$data['td_path_rujukan_2']]), ['class' => 'btn btn-success', 'target' => '_blank']) ;
                }, 
            ],
            [
                'attribute' =>'td_path_rujukan_3',
                'format'=>'html',
                'value' => function($data){
                    if ($data['td_path_rujukan_3']=='') {
                        return '';
                    }
                    return Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$data['td_path_rujukan_3']]), ['class' => 'btn btn-success', 'target' => '_blank','style'=>'margin-right:2px;']).Html::a('Download File',Url::to(['persetujuan/download','filename'=>$data['td_path_rujukan_3']]), ['class' => 'btn btn-success', 'target' => '_blank']) ;
                }, 
            ],
            'td_hak_kelas',
            'td_flag_status',
        ],
    ]) ?>

</div>
