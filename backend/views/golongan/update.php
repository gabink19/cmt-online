<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Golongan */

$this->title = 'Edit Golongan: ' . $model->tg_id;
$this->params['breadcrumbs'][] = ['label' => 'Golongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tg_id, 'url' => ['view', 'id' => $model->tg_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="golongan-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
