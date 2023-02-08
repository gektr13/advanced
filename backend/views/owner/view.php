<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */

/** @var backend\models\Transaction $transactions */
/** @var backend\models\OwnerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'owners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="owner-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',

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




    <h1>Автомобили</h1>

    <?= Html::a('Добавить авто', ['create-car', 'owner_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <br><br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'brand',
            'model',
            'year',
            'region',
            'price',
            'horsepower',
            [
                'class' => ActionColumn::className(),
                'template' => '{view}{delete}',
                'urlCreator' => function ($action, \backend\models\Car $model, $key, $index, $column) {

                    if ($action === 'view') {
                        $url ='index.php?r=owner/car-view&id='.$model->id;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url ='index.php?r=owner/car-delete&id='.$model->id;
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>

</div>
