<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tp_id',
            'tp_nik',
            'tp_nama_kk',
            'tp_nikes',
            'tp_status_kel',
            'tp_nama_kel',
            'tp_hr_pens',
            'tp_hr_host',
            'tp_band_posisi',
            'tp_tgl_lahir',
            'tp_umur',
            'tp_gol',
            'tp_tanggungan',
            'tp_tgl_pens',
            'tp_tgl_akhir_tanggunngan',
            'tp_jenis_peserta',
            [
                'attribute' =>'tp_jenis_kelamin',
                'value' => function($data){
                    return Yii::$app->params['jkelamin'][$data['tp_jenis_kelamin']];
                }, 
            ],
            'tp_no_bpjs',
            'tp_flag_active',
        ],
    ]) ?>

</div>
