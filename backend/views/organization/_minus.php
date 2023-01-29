<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Organization $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::input('text', 'different') ?>

    <br><br>

    <?= $form->errorSummary($model); ?>

    <br><br>

    <div class="form-group">
        <?= Html::submitButton('Списать', ['class' => 'btn btn-success']) ?>
    </div>

    <br><br>

    <?=  Html::a( 'Back', Yii::$app->request->referrer)?>

    <?php ActiveForm::end(); ?>

</div>
