<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TopDiagnosaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Top Diagnosas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="top-diagnosa-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Top Diagnosa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'ttd_id',
            'ttd_penamaan',
            'ttd_tdg_kode',
            'ttd_deskripsi',
            // 'flag_deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
