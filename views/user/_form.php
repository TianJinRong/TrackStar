<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 256]) ?>
	
	<?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => 256]) ?>
	

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => 256]) ?>

    <?= $form->field($model, 'access_token')->textInput(['maxlength' => 256]) ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
