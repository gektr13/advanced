<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\CreateTransactionAugment $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="organization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'brand')->textInput() ?>
    <?= $form->field($model, 'model')->textInput() ?>
    <?= $form->field($model, 'horsepower')->textInput() ?>
    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'year')->textInput() ?>
    <?= $form->field($model, 'region')->textInput() ?>

    <?= $form->errorSummary($model); ?>

    <br><br>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <br><br>

    <?=  Html::a( 'Back', Yii::$app->request->referrer)?>

    <?php ActiveForm::end(); ?>

</div>
