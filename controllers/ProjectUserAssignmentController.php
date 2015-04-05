<?php

namespace app\controllers;

use Yii;
use app\models\ProjectUserAssignment;
use app\models\ProjectUserAssignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProjectUserAssignmentController implements the CRUD actions for ProjectUserAssignment model.
 */
class ProjectUserAssignmentController extends Controller
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
        ];
    }

    /**
     * Lists all ProjectUserAssignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectUserAssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProjectUserAssignment model.
     * @param integer $project_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionView($project_id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($project_id, $user_id),
        ]);
    }

    /**
     * Creates a new ProjectUserAssignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProjectUserAssignment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'project_id' => $model->project_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectUserAssignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $project_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionUpdate($project_id, $user_id)
    {
        $model = $this->findModel($project_id, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'project_id' => $model->project_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectUserAssignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $project_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionDelete($project_id, $user_id)
    {
        $this->findModel($project_id, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProjectUserAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $project_id
     * @param integer $user_id
     * @return ProjectUserAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($project_id, $user_id)
    {
        if (($model = ProjectUserAssignment::findOne(['project_id' => $project_id, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
