<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Organization $model */

$this->title = 'Начисление на баланс: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organization-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_plus', [
        'model' => $model,
    ]) ?>

</div>
