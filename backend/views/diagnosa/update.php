<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Diagnosa */

$this->title = 'Edit Diagnosa: ' . $model->tdg_id;
$this->params['breadcrumbs'][] = ['label' => 'Diagnosas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tdg_id, 'url' => ['view', 'id' => $model->tdg_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="diagnosa-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
