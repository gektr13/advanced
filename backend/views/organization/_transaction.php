<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\Organization $model */
/** @var backend\models\Transaction $transaction */
/** @var yii\widgets\ActiveForm $form */

$transaction->type = true;

?>

<div class="organization-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($transaction, 'value')->textInput() ?>
    <?= $form->field($transaction, 'purpose')->textInput() ?>
    <?= $form->field($transaction, 'type')->radioList([
            true => 'Начислить',
            false => 'Снять',
        ])->label('Тип транзакции');

    ?>
    <?= $form->errorSummary($model); ?>

    <br><br>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <br><br>

    <?=  Html::a( 'Back', Yii::$app->request->referrer)?>

    <?php ActiveForm::end(); ?>

</div>
