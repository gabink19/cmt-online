<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HrPens */

$this->title = 'Edit Hr Pens: ' . $model->thp_id;
$this->params['breadcrumbs'][] = ['label' => 'Hr Pens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->thp_id, 'url' => ['view', 'id' => $model->thp_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="hr-pens-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
