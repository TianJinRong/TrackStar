<?php

namespace app\controllers;

use Yii;
use app\models\Issue;
use app\models\Project;
use app\models\Comment;
use app\models\IssueSearch;
use app\models\ProjectContextFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IssueController implements the CRUD actions for Issue model.
 */
class IssueController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
			'projectContext' => [
                'class' => ProjectContextFilter::className(),
				'actions' => ['create'],
            ],
        ];
    }

    /**
     * Lists all Issue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IssueSearch();
		if(null === $this->project)
		{
		} else 
		{
			$searchModel->project_id = $this->project->id; // 初始化
		}
		
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionTestIndex()
    {
        $searchModel = new IssueSearch();
        var_dump($searchModel);
		
		$model = new Issue();
		var_dump($model);
		
		echo "IssueSearch:".$searchModel->project_id;
		$searchModel->project_id = 1;
		echo "IssueSearch:".$searchModel->project_id;
    }

    /**
     * Displays a single Issue model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$issue = $this->findModel($id);
		$comments = Comment::find()->where(['issue_id' => $id])->all();
		$comment = new Comment();
		$comment->issue_id = $id;
		if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
			$session = Yii::$app->session;
			$session->setFlash('addCommentResult','Comment has been added to the issue.');
        }
		
        return $this->render('view', [
            'model' => $issue,
			'comments' => $comments,
			'newComment' => $comment,
        ]);
    }

    /**
     * Creates a new Issue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Issue();
		/* 从behavior中读过来的_project */
		$model->project_id = $this->project->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Issue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Issue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Issue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Issue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Issue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
