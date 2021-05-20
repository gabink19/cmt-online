<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CmsPortal */

$this->title = 'Create Cms Portal';
$this->params['breadcrumbs'][] = ['label' => 'Cms Portals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-portal-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
