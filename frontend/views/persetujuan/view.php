<?php

use frontend\models\Pendaftaran;
use yii\helpers\Html;
use frontend\models\Peserta;
use yii\widgets\DetailView;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model frontend\models\Persetujuan */
$nama = @Pendaftaran::findOne($model->tpt_td_id)->td_nama_kel;

$this->title = "Data Pasien ".$nama;
$this->params['breadcrumbs'][] = ['label' => 'Persetujuans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $nama;
\yii\web\YiiAsset::register($this);
?>
<div class="persetujuan-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?php
         if ($model->tpt_flag_status=='') {
            echo Html::a('Edit', ['update', 'id' => $model->tpt_id], ['class' => 'btn btn-primary']);
            echo Html::a('Delete', ['delete', 'id' => $model->tpt_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]); 
         }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'tpt_id',
            'tpt_tp_nikes',
           [
                'attribute' =>'tpt_td_id',
                'label'=>'Pegawai',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tpt_td_id'])->td_tp_nama_kk;
                }, 
            ],
            [
                'attribute' =>'tpt_td_id',
                'label'=>'Peserta',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tpt_td_id'])->td_nama_kel;
                }, 
            ],
            [
                'label' =>'Nomor Rekam Medis',
                'attribute' =>'rekmedis',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tpt_td_id'])->td_rekam_medis;
                }, 
            ],
            [
                'label' =>'Tujuan',
                'attribute' =>'tpt_td_id',
                'value' => function($data){
                    return @Yii::$app->params['tujuan'][Pendaftaran::findOne($data['tpt_td_id'])->td_tujuan];
                }, 
            ],
            'tpt_td_id',
            [
                'label'=>'Diagnosa',
                'attribute' =>'tpt_diagnosa',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $band = $session->get('diagnosa');
                    return @ArrayHelper::map($band, 'tdg_id', 'tdg_penamaan')[$data['tpt_diagnosa']];
                }, 
            ],
            [
                'attribute' =>'tpt_path_permintaan_tindak',
                'format'=>'html',
                'value' => function($data){
                    return Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$data['tpt_path_permintaan_tindak']]), ['class' => 'btn btn-success', 'target' => '_blank','style'=>'margin-right:2px;']).Html::a('Download File',Url::to(['persetujuan/download','filename'=>$data['tpt_path_permintaan_tindak']]), ['class' => 'btn btn-success', 'target' => '_blank']) ;
                }, 
            ],
            // 'tpt_flag_status',
            // 'tpt_id_user_backend',
            // 'tpt_id_user_frontend',
            // 'tpt_nama_mitra',
            // 'tpt_nama_user_backend',
            'tgl_permintaan',
            'tgl_persetujuan',
            'tpt_catatan_mitra',
            'tpt_catatan_yakes',
            [
                'attribute' =>'tpt_flag_status',
                'value' => function($data){
                    return ($data['tpt_flag_status']=='')?'Belum Di proses':@Yii::$app->params['persetujuan'][$data['tpt_flag_status']];
                }, 
            ],
            [
                'attribute' =>'biaya',
                'value' => function($data){
                    return number_format($data['biaya'],0,",",".");
                }, 
            ],
            [
                'attribute' =>'biaya_disetujui',
                'value' => function($data){
                    return number_format($data['biaya_disetujui'],0,",",".");
                }, 
            ],
            // 'first_ip_backend',
            // 'last_ip_backend',
            // 'first_ip_frontend',
            // 'last_ip_frontend',
            // 'first_date_backend',
            // 'last_date_backend',
            // 'first_date_frontend',
            // 'last_date_frontend',
            // 'first_user_backend',
            // 'last_user_backend',
            // 'first_user_frontend',
            // 'last_user_frontend',
        ],
    ]) ?>

</div>
