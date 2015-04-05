<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = 'Add user to '.$model->project->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?php 
	if(Yii::$app->session->hasFlash('addUserToProjectResult'))
	{
		echo Yii::$app->session->getFlash('addUserToProjectResult');
	}?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->dropDownList($model->usernameOptions) ?>

    <?= $form->field($model, 'rolename')->dropDownList($model->userRoleOptions) ?>

    <div class="form-group">
        <?= Html::submitButton('Add User', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
