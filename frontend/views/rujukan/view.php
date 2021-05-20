<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Rujukan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rujukans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rujukan-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'tr_no_regis',
            'tr_no_rujukan',
            'tr_tujuan',
            'tr_nama_dokter',
            'tr_nama_pasien',
            'tr_umur',
            'tr_nikes',
            'tr_nama_kk',
            'tr_band',
            'tr_hak_kelas',
            'tr_anamnese',
            'tr_diagnosa',
            'tr_tindakan',
            'tr_tgl_rujukan',
            'tr_nama_jaminan',
            'flag_deleted',
            'path_file',
            'tr_td_id',
            'date_create',
        ],
    ]) ?>

</div>
