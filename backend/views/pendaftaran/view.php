<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\Peserta;

/* @var $this yii\web\View */
/* @var $model frontend\models\Pendaftaran */

$this->title = $model->td_tp_nikes;
$this->params['breadcrumbs'][] = ['label' => 'Pendaftarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pendaftaran-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->td_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->td_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>

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
            [
                'attribute' =>'td_tp_nikes',
                'label'=>'Kategori Host',
                'value' => function($data){
                    $kategori_host = Peserta::find()->select(['kategori_host'])->where(['=','tp_nikes', $data['td_tp_nikes']])->one()->kategori_host;
                    return @Yii::$app->params["kategori_host"][$kategori_host];
                }, 
            ],
            'td_umur',
            'td_tp_nama_kk',
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
            // 'td_tp_jenis_peserta',
            'td_mitra',
            [
                'attribute' =>'td_path_rujukan',
                'format'=>'html',
                'value' => function($data){
                    return Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$data['td_path_rujukan']]), ['class' => 'btn btn-success', 'target' => '_blank','style'=>'margin-right:2px;']).Html::a('Download File',Url::to(['persetujuan/download','filename'=>$data['td_path_rujukan']]), ['class' => 'btn btn-success', 'target' => '_blank']) ;
                }, 
            ],
            [
                'attribute' =>'td_path_rujukan_2',
                'format'=>'html',
                'value' => function($data){
                    return Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$data['td_path_rujukan_2']]), ['class' => 'btn btn-success', 'target' => '_blank','style'=>'margin-right:2px;']).Html::a('Download File',Url::to(['persetujuan/download','filename'=>$data['td_path_rujukan_2']]), ['class' => 'btn btn-success', 'target' => '_blank']) ;
                }, 
            ],
            [
                'attribute' =>'td_path_rujukan_3',
                'format'=>'html',
                'value' => function($data){
                    return Html::a('View File',Url::to(['persetujuan/viewpdf','filename'=>$data['td_path_rujukan_3']]), ['class' => 'btn btn-success', 'target' => '_blank','style'=>'margin-right:2px;']).Html::a('Download File',Url::to(['persetujuan/download','filename'=>$data['td_path_rujukan_3']]), ['class' => 'btn btn-success', 'target' => '_blank']) ;
                }, 
            ],
            'td_hak_kelas',
            'td_flag_status',
        ],
    ]) ?>

</div>
