<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Tabs;
use backend\models\Menu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Management Menu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Menu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $Contentmenu = GridView::widget([
        'dataProvider' => $dataProvider,'responsiveWrap' => false,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            // 'parent',
            [
                'attribute' =>'parent',
                'value' => function($data){
                    $kategori_host = Menu::find()->select(['name'])->where(['=','id', $data['parent']])->one()->name;
                    return @$kategori_host;
                }, 
            ],
            'route',
            'order',
            //'data',
            //'status',
            //'icon',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php $Contentcrud = GridView::widget([
        'dataProvider' => $dataProvider1,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            // 'parent',
            'route',
            // 'order',
            //'data',
            //'status',
            //'icon',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Menu',
                'content' => $Contentmenu,
                'active' => true
            ],
            [
                'label' => 'Crud',
                'content' => $Contentcrud,
            ],
        ]
    ]);
	?>
</div>
