<?php

use yii\widgets\ActiveForm;
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

    <div class="car-id" data-attr="<?= $model->id; ?>"></div>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'brand',
            'model',
            'year',
            [
                'label' => 'Регион регистрации',
                'value' => $model->getRegionText(),
            ],

            'price',
            'horsepower',

        ],
    ]) ?>

    <?php
    $form = ActiveForm::begin();
    $items = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
    ];

    echo $form->field($model, 'month')->dropDownList($items, ['class'=>'tax-mth'])->label('Кол-во месяцев',['class'=>'tax-mth']);
    ActiveForm::end();
    ?>

    <input class="btn btn-primary tax-btn" value="Рассчитать налог за 2022 год" type="button">

    <div class="tax">
        <h1>Итог:</h1>
        <h2 class="tax-value"></h2>
    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(".tax").css("display", "none");
        $('.tax-btn').on('click', delRowOfTable);
    });

    function delRowOfTable() {

        const data = {
            'id': $('.car-id').attr('data-attr'),
            'month': $('#car-month').val(),
        };
        console.log(data);

        // отправляем данные на сервер
        $.ajax({
            url: '/index.php?r=owner/calculate-tax',
            type: 'post',
            data: data,
            success: function (data) {
                $(".tax-value").text(data + ' руб.');
                $(".tax").css("display", "block");
                $(".tax-btn").css("display", "none");
                $(".tax-mth").css("display", "none");

                console.log(data);
            },
            error: function () {
                console.log("error change_php");
            }
        })

        return false; // отменяем отправку данных формы
    }

</script>