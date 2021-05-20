<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BandPosisi */

$this->title = 'Edit Band Posisi: ' . $model->tbp_id;
$this->params['breadcrumbs'][] = ['label' => 'Band Posisis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tbp_id, 'url' => ['view', 'id' => $model->tbp_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="band-posisi-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
