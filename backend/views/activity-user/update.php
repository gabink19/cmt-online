<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityUser */

$this->title = 'Update Activity User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-user-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
