<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Owner $model */

$this->title = 'Update Owner: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Owner', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organization-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
