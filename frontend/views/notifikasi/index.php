<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\NotifikasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifikasis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifikasi-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Notifikasi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tn_id',
            'tn_kepada',
            'tn_user_mitra',
            'tn_tanggal',
            'tn_judul',
            //'tn_teks',
            //'tn_type_notif',
            //'tn_telah_dikirim',
            //'tn_telah_dibaca',
            //'tn_tipe_notif',
            //'tn_link:ntext',
            //'tn_user_id',
            //'tn_dibaca_tanggal',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
