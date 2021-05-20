<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RujukanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rujukans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rujukan-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Rujukan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tr_no_regis',
            'tr_no_rujukan',
            'tr_tujuan',
            'tr_nama_dokter',
            //'tr_nama_pasien',
            //'tr_umur',
            //'tr_nikes',
            //'tr_nama_kk',
            //'tr_band',
            //'tr_hak_kelas',
            //'tr_anamnese',
            //'tr_diagnosa',
            //'tr_tindakan',
            //'tr_tgl_rujukan',
            //'tr_nama_jaminan',
            //'flag_deleted',
            //'path_file',
            //'tr_td_id',
            //'date_create',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
