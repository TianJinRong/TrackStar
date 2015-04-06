<?php

namespace app\controllers;

use Yii;
use app\models\Issue;
use app\models\User;
use app\controllers\IssueController;
use app\models\IssueListSearch;
use app\models\Project;
use app\models\ProjectSearch;
use app\models\ProjectUserForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;


/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
					'delete' => ['post'],
					'delete-issue' => ['post'],
                ],
            ],
			'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'create', 'adduser'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update', 'create', 'adduser'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 显示该项目的问题
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$this->authorizePower($id);
		$issueSearchModel = new IssueListSearch();		
		$issueDataProvider = $issueSearchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('view', [
            'model' => $this->findModel($id),
			'issueDataProvider' => $issueDataProvider,
			'issueSearchModel' => $issueSearchModel,
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionAdduser($projectId)
    {
		// 检查当前用户是否有添加用户的权限
		if(!Yii::$app->user->can('createUser'))
		{
			throw new NotFoundHttpException('你没有权限访问该页。');
		}
		
		
		$form = new ProjectUserForm();
		$project = $this->findModel($projectId);
		$form->project = $project;
        if ($form->load(Yii::$app->request->post())) {
			$form->project = $project;
			if($form->validate())
			{
				// Display the message.
				$session = Yii::$app->session;
				$session->setFlash('addUserToProjectResult', $form->username.' has been added to the project.');
				// echo $session->getFlash('addUserToProjectSuccess');
				// return $this->redirect(['view', 'id' => $projectId]);
				$form = new ProjectUserForm();
				$form->project = $project;
				
			} else {
				$session = Yii::$app->session;
				$session->setFlash('addUserToProjectResult', $form->username.' failed to added to the project.');
			}
        } else {
			
        }
		// Display the add user form.
		return $this->render('adduser', [
			'model' => $form,
		]);
    }

    /**
     * Updates an existing Project model.
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
     * Deletes an existing Project model.
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
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/* 授权 */
	protected function authorizePower($projectId)
	{
		// 读取当前用户在该项目中的角色
		// 查找该用户是否存在
        $userId = Yii::$app->user->id;
		$user = User::findOne($userId);
		$project = $this->findModel($projectId);
		if (!$user) {
			throw new NotFoundHttpException('The current user does not exist.');
		} else if($project->isUserInProject($user)) {
			// 授权
			$rolenames = $project->userRolenames;
			$auth = Yii::$app->authManager;
			foreach($rolenames as $rolename) {
				// 如果没有授权则授权给该用户
				if(null === $auth->getAssignment($rolename, $user->id)) {
					$role = $auth->getRole($rolename);
					$auth->assign($role, $user->id);
				}
			}
		}
	}
}
