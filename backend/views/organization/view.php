<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\Organization $model */
/** @var backend\models\Transaction $transactions */
/** @var backend\models\OrganizationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="organization-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'balance',
            [
                'attribute' => 'balance',
                'value' => function ($model) {
                    return $model->balance;
                },
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата создания',
                'format' => 'datetime', // Доступные модификаторы - date:datetime:time
                'headerOptions' => ['width' => '200'],
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Псоледнее обновлнеие',
                'format' => 'datetime',
                'headerOptions' => ['width' => '200'],
            ],
        ],
    ]) ?>

    <?= Html::a('Добавить на баланс', ['augment-transaction', 'organization_id' => $model->id], ['class' => 'btn btn-primary']) ?>

    <?= Html::a('Снять с баланса', ['deduct-transaction', 'organization_id' => $model->id], ['class' => 'btn btn-primary']) ?>

    <br><br>
    <h1>Транзакции</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'value',
            'purpose',
            [
                'attribute' => 'type',
                'value' => function ($data) {
                    return !empty($data->type) ? 'Поплнение' : 'Снятие';
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата операции',
                'format' => 'datetime',
                'headerOptions' => ['width' => '200'],
            ],
        ],
    ]); ?>

</div>
