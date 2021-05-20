<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PersetujuanTindak */

$this->title = $model->tpt_id;
$this->params['breadcrumbs'][] = ['label' => 'Persetujuan Tindaks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="persetujuan-tindak-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->tpt_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->tpt_id], [
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
            'tpt_id',
            'tpt_uniq_code',
            'tpt_tp_nikes',
            'tpt_td_id',
            'tpt_catatan_mitra',
            'tpt_path_permintaan_tindak',
            'tpt_flag_status',
            'tpt_id_user_backend',
            'tpt_catatan_yakes',
            'tpt_id_user_frontend',
            'tpt_nama_mitra',
            'tpt_nama_user_backend',
            'tgl_permintaan',
            'tgl_persetujuan',
            'first_ip_backend',
            'last_ip_backend',
            'first_ip_frontend',
            'last_ip_frontend',
            'first_date_backend',
            'last_date_backend',
            'first_date_frontend',
            'last_date_frontend',
            'first_user_backend',
            'last_user_backend',
            'first_user_frontend',
            'last_user_frontend',
            'flag_deleted',
            'tpt_diagnosa',
            'history_note',
            'biaya',
            'biaya_disetujui',
        ],
    ]) ?>

</div>
