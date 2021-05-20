<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Pendaftaran */

$this->title = 'Edit Pendaftaran: ' . $model->td_tp_nikes;
$this->params['breadcrumbs'][] = ['label' => 'Pendaftarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->td_id, 'url' => ['view', 'id' => $model->td_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="pendaftaran-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
