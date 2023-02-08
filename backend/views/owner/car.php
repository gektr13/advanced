<?php


/** @var yii\web\View $this */
/** @var \backend\models\CreateTransactionAugment $model */

$this->title = 'Добавление авто для :' . $model->owner->name;
$this->params['breadcrumbs'][] = ['label' => 'Owners', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organization-update">

    <?= $this->render('_car', [
        'model' => $model,
    ]) ?>

</div>
