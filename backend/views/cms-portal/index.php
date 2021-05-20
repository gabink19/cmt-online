<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CmsPortalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cms Portals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-portal-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cms Portal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'banner1',
            'banner2',
            'banner3',
            'banner4',
            //'banner5',
            //'fitur1',
            //'fitur2',
            //'fitur3',
            //'deskripsi',
            //'deskripsi_img1',
            //'deskripsi_img2',
            //'deskripsi_img3',
            //'deskripsi_text1',
            //'deskripsi_text2',
            //'deskripsi_text3',
            //'partner_img',
            //'partner_text',
            //'last_update',
            //'last_user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
