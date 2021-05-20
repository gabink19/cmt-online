<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tanggungan */

$this->title = 'Edit Tanggungan: ' . $model->tt_id;
$this->params['breadcrumbs'][] = ['label' => 'Tanggungans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tt_id, 'url' => ['view', 'id' => $model->tt_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="tanggungan-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
