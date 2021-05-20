<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use frontend\models\Peserta;

/* @var $this yii\web\View */
/* @var $model frontend\models\Pendaftaran */

$this->title = "Data Pasien ".$model->td_nama_kel;
$this->params['breadcrumbs'][] = ['label' => 'Daftar Pasien', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->td_nama_kel;
\yii\web\YiiAsset::register($this);
?>
<div class="pendaftaran-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'td_tp_nikes',
            [
                'attribute' =>'td_tp_nama_kk',
                'value' => function($data){
                    return $data['td_tp_nama_kk'];
                }, 
            ],
            [
                'attribute' =>'td_nama_kel',
                'value' => function($data){
                    return $data['td_nama_kel'];
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
            'td_path_rujukan',
            'td_hak_kelas',
            // 'td_flag_status',
            // [
            //     'attribute' =>'td_flag_status',
            //     'value' => function($data){
            //         $td_flag_status = $data['td_flag_status'];
            //         return (@$td_flag_status==1)?'Meninggal':'Active';
            //     }, 
            // ],
        ],
    ]) ?>

</div>
