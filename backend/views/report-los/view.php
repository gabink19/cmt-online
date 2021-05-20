<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ReportLos */

$this->title = $model->tbs_id;
$this->params['breadcrumbs'][] = ['label' => 'Report Los', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="report-los-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->tbs_id], ['class' => 'btn btn-primary']) ?>
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
            'tbs_id',
            'tbs_tp_nikes',
            'tbs_td_id',
            'tbs_catatan_mitra',
            'tbs_path_billing',
            'tbs_flag_status',
            'tbs_id_user_backend',
            'tbs_catatan_yakes',
            'tbs_id_user_frontend',
            'tbs_nama_mitra',
            'tbs_nama_user_backend',
            'tgl_billing',
            'tgl_billing_diresponse',
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
            'tbs_biaya',
            'tbs_diagnosa',
        ],
    ]) ?>

</div>
