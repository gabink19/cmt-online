<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Rujukan */

$this->title = 'Create Rujukan';
$this->params['breadcrumbs'][] = ['label' => 'Rujukans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rujukan-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
