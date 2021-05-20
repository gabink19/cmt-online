<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Bidang */

$this->title = 'Edit Bidang: ' . $model->tb_id;
$this->params['breadcrumbs'][] = ['label' => 'Bidangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tb_id, 'url' => ['view', 'id' => $model->tb_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="bidang-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'left' => $left,
        'right' => $right,
        'all' => $all,
    ]) ?>

</div>
