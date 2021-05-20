<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Notifikasi */

$this->title = $model->tn_id;
$this->params['breadcrumbs'][] = ['label' => 'Notifikasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="notifikasi-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->tn_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->tn_id], [
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
            'tn_id',
            'tn_kepada',
            'tn_user_mitra',
            'tn_tanggal',
            'tn_judul',
            'tn_teks',
            'tn_type_notif',
            'tn_telah_dikirim',
            'tn_telah_dibaca',
            'tn_tipe_notif',
            'tn_link:ntext',
            'tn_user_id',
            'tn_dibaca_tanggal',
        ],
    ]) ?>

</div>
