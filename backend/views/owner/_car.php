<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\CreateTransactionAugment $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="organization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'brand')->textInput()->label('Марка') ?>
    <?= $form->field($model, 'model')->textInput()->label('Модель') ?>
    <?= $form->field($model, 'horsepower')->textInput()->label('Кол-во л.с.') ?>
    <?= $form->field($model, 'price')->textInput()->label('Цена') ?>
    <?= $form->field($model, 'year')->textInput()->label('Год выпуска') ?>
    <?= $form->field($model, 'region')->dropDownList([
        '1' => 'Москва',
        '2' => 'Санкт-петербург',
        '3' => 'Казань'
    ])->label('Регион регистрации') ?>


    <br><br>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <br><br>

    <?= Html::a('Back', Yii::$app->request->referrer) ?>

    <?php ActiveForm::end(); ?>

</div>
