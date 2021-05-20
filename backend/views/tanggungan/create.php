<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tanggungan */

$this->title = 'Create Tanggungan';
$this->params['breadcrumbs'][] = ['label' => 'Tanggungans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tanggungan-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
