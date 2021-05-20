<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\HakKelas */

$this->title = $model->thk_id;
$this->params['breadcrumbs'][] = ['label' => 'Hak Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="hak-kelas-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->thk_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->thk_id], [
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
            'thk_id',
            'thk_rumah_sakit',
            'id_user',
            'I',
            'II',
            'III',
            'IV',
            'V',
            'VI',
            'VII',
            // 'flag_active',
            // 'flag_deleted',
        ],
    ]) ?>

</div>
