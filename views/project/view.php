<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use app\components\RecentCommentsWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?= Html::a('Create Issue', ['issue/create', 'pid' => $model->id], ['class' => 'btn btn-success']) ?>
		<?php 
		// 检查当前用户是否有添加用户的权限
		if(Yii::$app->user->can('createUser'))
		{
			echo Html::a('Add User', ['adduser', 'projectId' => $model->id], ['class' => 'btn btn-primary']);
		}
		?>
		
		<?= Html::a('Add User Test Button', ['adduser', 'projectId' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'create_time',
            'create_user_id',
            'update_time',
            'update_user_id',
        ],
    ]) ?>
	
	<h2>Project Issues</h2>	
	<?= GridView::widget([
        'dataProvider' => $issueDataProvider,
		'filterModel' => $issueSearchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'name',
			[
				'attribute' => 'project_id',
				'value' => function ($issue) {
					return $issue->project->name;
				},
				'format' => 'text',
				'label' => 'Name',
			],
            'description:ntext',
            // 'project_id',
			[
				'attribute' => 'project_id',
				'value' => function ($issue) {
					return $issue->project->name;
				},
				'format' => 'text',
				'label' => 'Project',				
			],
            //'type_id',
			[
				'attribute' => 'type_id',
				'value' => function ($issue) {
					return $issue->type;
				},
				'format' => 'text',
				'label' => 'Issue Type',
			],
			[
				'attribute' => 'status_id',
				'value' => function ($issue) {
					return $issue->status;
				},
				'format' => 'text',
				'label' => 'Issue Status',
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'controller' => 'issue',
			],
            // 'status_id',
            // 'owner_id',
            // 'requester_id',
            // 'create_time',
            // 'create_user_id',
            // 'update_time',
            // 'update_user_id',
        ],
    ]); ?>

	<?= RecentCommentsWidget::widget(['projectId' => $model->id]) ?>
	
	<?php 
		var_dump(Yii::$app->user);
	?>

</div>
