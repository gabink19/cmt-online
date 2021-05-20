<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JenisPeserta */

$this->title = 'Edit Jenis Peserta: ' . $model->tjp_id;
$this->params['breadcrumbs'][] = ['label' => 'Jenis Pesertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tjp_id, 'url' => ['view', 'id' => $model->tjp_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="jenis-peserta-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
