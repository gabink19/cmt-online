<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Persetujuan */

$this->title = 'Edit Persetujuan: ' . $model->tpt_id;
$this->params['breadcrumbs'][] = ['label' => 'Persetujuans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tpt_id, 'url' => ['view', 'id' => $model->tpt_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="persetujuan-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
