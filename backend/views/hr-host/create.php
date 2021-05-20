<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HrHost */

$this->title = 'Create Hr Host';
$this->params['breadcrumbs'][] = ['label' => 'Hr Hosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hr-host-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
