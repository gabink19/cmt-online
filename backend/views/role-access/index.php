<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RoleAccessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Role Accesses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-access-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Role Access', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'usermode',
            'menu_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
