<?php

use backend\models\Organization;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\OrganizationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Organizations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Organization', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'balance',
                'value' => function ($model) {
                    return  Organization::getBalance($model->id);
                },
            ],
            [
                'attribute'=>'created_at',
                'label'=>'Дата создания',
                'format'=>'datetime',
                'headerOptions' => ['width' => '200'],
            ],
            [
                'attribute'=>'updated_at',
                'label'=>'Последнее обновление',
                'format'=>'datetime',
                'headerOptions' => ['width' => '200'],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Organization $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
