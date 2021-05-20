<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HrHost */

$this->title = 'Edit Hr Host: ' . $model->thh_id;
$this->params['breadcrumbs'][] = ['label' => 'Hr Hosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->thh_id, 'url' => ['view', 'id' => $model->thh_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="hr-host-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
