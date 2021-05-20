<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Peserta;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Peserta */

$this->title = $model->tp_nik;
$this->params['breadcrumbs'][] = ['label' => 'Pesertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="peserta-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('Update', ['update', 'tp_id' => $model->tp_id, 'tp_nikes' => $model->tp_nikes], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tp_id' => $model->tp_id, 'tp_nikes' => $model->tp_nikes], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php 
    $session = Yii::$app->session;
    $pens = $session->get('pens');
    $host = $session->get('host');
    $band = $session->get('band');
    $tanggungan = $session->get('tanggungan');
    // echo "<pre>"; print_r($pens);echo "</pre>";die();
?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tp_id',
            'tp_nik',
            'tp_nama_kk',
            'tp_nikes',
            'tp_status_kel',
            'tp_nama_kel',
            [
                'attribute' =>'tp_hr_pens',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $pens = $session->get('pens');
                    return @ArrayHelper::map($pens, 'thp_id', 'thp_penamaan')[$data['tp_hr_pens']];
                }, 
            ],
            [
                'attribute' =>'tp_hr_host',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $host = $session->get('host');
                    return @ArrayHelper::map($host, 'thh_id', 'thh_penamaan')[$data['tp_hr_host']];
                }, 
            ],
            
            [
                'attribute' =>'tp_nikes',
                'label'=>'Kategori Host',
                'value' => function($data){
                    $kategori_host = Peserta::find()->select(['kategori_host'])->where(['=','tp_nikes', $data['tp_nikes']])->one()->kategori_host;
                    return @Yii::$app->params["kategori_host"][$kategori_host];
                }, 
            ],
            [
                'attribute' =>'tp_band_posisi',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $band = $session->get('band');
                    return @ArrayHelper::map($band, 'tbp_id', 'tbp_penamaan')[$data['tp_band_posisi']];
                }, 
            ],
            'tp_tgl_lahir',
            'tp_umur',
            [
                'attribute' =>'tp_gol',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $golongan = $session->get('golongan');
                    return @ArrayHelper::map($golongan, 'tg_id', 'tg_penamaan')[$data['tp_gol']];
                }, 
            ],
            [
                'attribute' =>'tp_tanggungan',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $tanggungan = $session->get('tanggungan');
                    return @ArrayHelper::map($tanggungan, 'tt_id', 'tt_penamaan')[$data['tp_tanggungan']];
                }, 
            ],
            'tp_tgl_pens',
            'tp_tgl_akhir_tanggunngan',
            [
                'attribute' =>'tp_jenis_peserta',
                'label'=>'Klinik Faskes',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $jenis_peserta = $session->get('jenis_peserta');
                    return @ArrayHelper::map($jenis_peserta, 'tjp_id', 'tjp_penamaan')[$data['tp_jenis_peserta']];
                }, 
            ],
            [
                'attribute' =>'tp_jenis_kelamin',
                'value' => function($data){
                    return Yii::$app->params['jkelamin'][$data['tp_jenis_kelamin']];
                }, 
            ],
            'tp_no_bpjs',
            [
                'attribute' =>'tp_flag_active',
                'value' => function($data){
                    return [0=>'Masih Hidup',1=>'Sudah Meninggal'][$data['tp_flag_active']];
                }, 
            ],
        ],
    ]) ?>

</div>
