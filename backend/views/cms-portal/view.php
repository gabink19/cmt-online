<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CmsPortal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cms Portals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cms-portal-view">

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
        'attributes' => [
            'id',
            'banner1',
            'banner2',
            'banner3',
            'banner4',
            'banner5',
            'fitur1',
            'fitur2',
            'fitur3',
            'deskripsi',
            'deskripsi_img1',
            'deskripsi_img2',
            'deskripsi_img3',
            'deskripsi_text1',
            'deskripsi_text2',
            'deskripsi_text3',
            'partner_img',
            'partner_text',
            'last_update',
            'last_user',
        ],
    ]) ?>

</div>
