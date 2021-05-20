<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\Bidang;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
if ($model->type_user==0) {
    $attr= [
            'id',
            'username',
            'email:email',
            'status',
            'created_at',
            'no_telp',
            // 'type_user',
            [
                'attribute' =>'type_user',
                'value' => function($data){
                    return Yii::$app->params['typeUser'][$data['type_user']];
                }, 
            ],
            'nama',
            [
                'attribute' =>'bidang_user',
                'value' => function($data){
                    return ArrayHelper::map(Bidang::find()->select(['tb_id', 'tb_nama_bidang'])->all(), 'tb_id', 'tb_nama_bidang')[$data['bidang_user']];
                }, 
            ],
            'flag_active',
        ];
}else{
     $attr= [
            'id',
            'username',
            'email:email',
            'status',
            'created_at',
            'no_telp',
            // 'type_user',
            [
                'attribute' =>'type_user',
                'value' => function($data){
                    return Yii::$app->params['typeUser'][$data['type_user']];
                }, 
            ],
            'rs_mitra',
            [
                'attribute' =>'bidang_mitra',
                'value' => function($data){
                    return ArrayHelper::map(Bidang::find()->select(['tb_id', 'tb_nama_bidang'])->all(), 'tb_id', 'tb_nama_bidang')[$data['bidang_mitra']];
                }, 
            ],
            'alamat_rs',
            'flag_active',
        ];
}
?>
<div class="user-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attr,
    ]) ?>

</div>
