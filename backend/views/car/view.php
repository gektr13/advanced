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


$this->title = $model->brand . ' ' . $model->model;
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
            'brand',
            'model',
            'year',
            'region',
            'price',
            'horsepower',
        ],
    ]) ?>

    <?= Html::a('Рассчитать налог', ['create-car', 'owner_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <br><br>

</div>
