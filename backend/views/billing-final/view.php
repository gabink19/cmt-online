<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use frontend\models\Pendaftaran;
use frontend\models\Peserta;

/* @var $this yii\web\View */
/* @var $model frontend\models\BillingSementara */

$nama = @Pendaftaran::findOne($model->tbs_td_id)->td_nama_kel;
$this->title = "Data Pasien ".$nama;
$this->params['breadcrumbs'][] = ['label' => 'Billing Sementaras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $nama;
\yii\web\YiiAsset::register($this);
?>
<div class="billing-sementara-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'tbs_id',
            'tbs_tp_nikes',
            'tbs_td_id', 
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
            [
                'label' =>'File Billing',
                'attributes' =>'tbs_path_billing',
                'format'=>'html',
                'value' => function($data){
                    return Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$data['tbs_path_billing']]), ['class' => 'btn btn-success', 'target' => '_blank','style'=>'margin-right:2px;']).Html::a('Download File',Url::to(['persetujuan/download','filename'=>$data['tbs_path_billing']]), ['class' => 'btn btn-success', 'target' => '_blank']) ;
                }, 
            ],
            // 'tbs_flag_status',
            [
                'label' =>'Status',
                'attributes' =>'tbs_flag_status',
                'value' => function($data){
                    return @Yii::$app->params['persetujuanBilling'][$data['tbs_flag_status']];
                }, 
            ],
            'tbs_nama_mitra',
            [
                'attribute' =>'tbs_tp_nikes',
                'label'=>'Kategori Host',
                'value' => function($data){
                    $kategori_host = Peserta::find()->select(['kategori_host'])->where(['=','tp_nikes', $data['tbs_tp_nikes']])->one()->kategori_host;
                    return @Yii::$app->params["kategori_host"][$kategori_host];
                }, 
            ],
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
