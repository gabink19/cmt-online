<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HrPens */

$this->title = 'Create Hr Pens';
$this->params['breadcrumbs'][] = ['label' => 'Hr Pens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hr-pens-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
