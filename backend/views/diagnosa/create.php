<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Diagnosa */

$this->title = 'Create Diagnosa';
$this->params['breadcrumbs'][] = ['label' => 'Diagnosas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diagnosa-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
