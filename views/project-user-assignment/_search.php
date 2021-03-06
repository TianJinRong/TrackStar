<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjectUserAssignmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-user-assignment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'project_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'create_time') ?>

    <?= $form->field($model, 'create_user_id') ?>

    <?= $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'update_user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
