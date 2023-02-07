<?php


/** @var yii\web\View $this */
/** @var \backend\models\CreateTransactionAugment $model */

$this->title = 'Создание транзакции для :' . $model->organization->name;
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organization-update">

    <?= $this->render('_transaction', [
        'model' => $model,
    ]) ?>

</div>
