<?php


/** @var yii\web\View $this */
/** @var backend\models\Organization $model */
/** @var backend\models\Transaction $transaction */

$this->title = 'Создание транзакции для :' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organization-update">

    <?= $this->render('_transaction', [
        'model' => $model,
        'transaction' => $transaction,
    ]) ?>

</div>
