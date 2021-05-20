<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Notifikasi */

$this->title = 'Update Notifikasi: ' . $model->tn_id;
$this->params['breadcrumbs'][] = ['label' => 'Notifikasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tn_id, 'url' => ['view', 'id' => $model->tn_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="notifikasi-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
