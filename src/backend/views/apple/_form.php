<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Apple $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="apple-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_create')->textInput() ?>

    <?= $form->field($model, 'date_fall')->textInput() ?>

    <?= $form->field($model, 'fallen')->textInput() ?>

    <?= $form->field($model, 'size')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
