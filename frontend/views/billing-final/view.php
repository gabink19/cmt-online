<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use frontend\models\Pendaftaran;

/* @var $this yii\web\View */
/* @var $model frontend\models\BillingSementara */

$nama = @Pendaftaran::findOne($model->tbs_td_id)->td_nama_kel;
$this->title = "Data Pasien ".$nama;
// $this->title = $model->tbs_id;
$this->params['breadcrumbs'][] = ['label' => 'Billing Sementaras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $nama;
\yii\web\YiiAsset::register($this);
?>
<div class="billing-sementara-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('Edit', ['update', 'id' => $model->tbs_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->tbs_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'tbs_id',
            'tbs_tp_nikes',
            'tbs_td_id', 
            [
                'attribute' =>'tbs_td_id',
                'label'=>'Pegawai',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tbs_td_id'])->td_tp_nama_kk;
                }, 
            ],
            [
                'attribute' =>'tbs_td_id',
                'label'=>'Peserta',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tbs_td_id'])->td_nama_kel;
                }, 
            ],
            [
                'label' =>'Nomor Rekam Medis',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tbs_td_id'])->td_rekam_medis;
                }, 
            ],
            [
                'label' =>'Tujuan',
                'value' => function($data){
                    return @Yii::$app->params['tujuan'][@Pendaftaran::findOne($data['tbs_td_id'])->td_tujuan];
                }, 
            ],
            'tbs_diagnosa',
            [
                'label' =>'File Billing',
                'attributes' =>'tbs_path_billing',
                'format'=>'html',
                'value' => function($data){
                    return Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$data['tbs_path_billing']]), ['class' => 'btn btn-success', 'target' => '_blank','style'=>'margin-right:2px;']).Html::a('Download File',Url::to(['persetujuan/download','filename'=>$data['tbs_path_billing']]), ['class' => 'btn btn-success', 'target' => '_blank']) ;
                }, 
            ],
            [
                'label' =>'File Resume',
                'attributes' =>'tbs_path_resume',
                'format'=>'html',
                'value' => function($data){
                    return Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$data['tbs_path_resume']]), ['class' => 'btn btn-success', 'target' => '_blank','style'=>'margin-right:2px;']).Html::a('Download File',Url::to(['persetujuan/download','filename'=>$data['tbs_path_resume']]), ['class' => 'btn btn-success', 'target' => '_blank']) ;
                }, 
            ],
            [
                'label' =>'Status',
                'attributes' =>'tbs_flag_status',
                'value' => function($data){
                    return @Yii::$app->params['persetujuanBilling'][$data['tbs_flag_status']];
                }, 
            ],
            'tbs_nama_mitra',
            // 'tbs_nama_user_backend',
            'tbs_id_user_frontend',
            'tbs_catatan_mitra',
            // 'tbs_id_user_backend',
            'tbs_catatan_yakes',
            'tgl_billing',
            'tgl_billing_diresponse',
            [
                'attribute' =>'tbs_biaya',
                'value' => function($data){
                    return number_format($data['tbs_biaya'],0,",",".");
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
            // 'flag_deleted',
        ],
    ]) ?>

</div>
