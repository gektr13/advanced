<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Owner $model */

$this->title = 'Create Owner';
$this->params['breadcrumbs'][] = ['label' => 'Owners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
