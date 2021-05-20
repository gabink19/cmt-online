<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserMode */

$this->title = 'Create User Mode';
$this->params['breadcrumbs'][] = ['label' => 'User Modes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-mode-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
