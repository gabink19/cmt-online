<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,'responsiveWrap' => false,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'email:email',
            // 'status',
            // 'created_at',
            [
                'attribute' =>'created_at',
                'value' => function($data){
                    return date("Y-m-d H:i:s", $data['created_at']);
                }, 
            ],
            //'updated_at',
            //'first_user',
            //'first_ip',
            //'first_update',
            //'last_user',
            //'last_ip',
            //'last_update',
            //'active_date',
            //'usermode',
            //'flag_multiple',
            //'last_action',
            //'ip',
            //'flag_login',
            // 'lastvisit',
            //'no_telp',
            //'nama',
            //'bidang_user',
            //'flag_active',
            //'rs_mitra',
            //'bidang_mitra',
            //'alamat_rs',
            [
                'attribute' =>'type_user',
                'value' => function($data){
                    return Yii::$app->params['typeUser'][$data['type_user']];
                }, 
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
