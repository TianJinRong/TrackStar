<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Issue */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Issues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issue-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            //'project_id',
            //'type_id',
            //'status_id',
			[
				'label' => 'Project',
				'value' => $model->project->name,
			],
			[
				'label' => 'Type',
				'value' => $model->type,
			],
			[
				'label' => 'Status',
				'value' => $model->status,
			],
			[
				'label' => 'Owner',
				'value' => $model->owner->username,
			],
			[
				'label' => 'Requester',
				'value' => $model->requester->username,
			],
            //'owner_id',
            //'requester_id',
            'create_time',
            'create_user_id',
            'update_time',
            'update_user_id',
        ],
    ]) ?>

</div>

<?php 
// 列出评论列表
echo $this->render('_comment', [
		'comments' => $comments,
	]); 
?>


<?php 
// 添加comment的结果
if(Yii::$app->session->hasFlash('addCommentResult'))
{
	echo Yii::$app->session->getFlash('addCommentResult');
}
?>

<?php
// 添加评论
echo $this->render('_commentform', [
	'model' => $newComment,
]);
?>
