<?php
namespace app\models;

use Yii;
use yii\base\ActionEvent;
use yii\base\ActionFilter;
use yii\web\Controller;
use yii\di\Instance;
use yii\web\User;
use yii\web\ForbiddenHttpException;
/* 这个类的作用为：由于每一个issue都属于一个project，但是当要创建issue时，如果未确定其project，则不能创建。 */
class ProjectContextFilter extends ActionFilter
{	
	/* 该问题所属项目 */
	private $_project = null;

	public $actions = [];
	
	public function getProject()
	{
		return $this->_project;
	}
	
	/* 载入项目 */
	public function loadProject($project_id)
	{
		/* echo "loading...";
		echo $project_id; */
		//if the project property is null, create it based on input id
		if ($this->_project ===  null) {
			echo "the project property is null";
			$this->_project = Project::find()->where(['id' => $project_id])->one();
			if ($this->_project ===  null) {
				echo "数据库里面没有！";
				return $this->denyAccess();
			}
		}
		return $this->_project;
	}

    /**
     * Declares event handlers for the [[owner]]'s events.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @param ActionEvent $event
     * @return boolean
     * @throws MethodNotAllowedHttpException when the request method is not allowed.
     */
    public function beforeAction($action)
    {
		/* 当前动作：$action->id */
		/* 查看当前动作是不是需要验证 */
        if (in_array($action->id, $this->actions)) { 
			/* 需要验证则载入其项目 */
            //set the project identifier based on either the GET or POST input
			//request variables, since we allow both types for our actions
			echo "验证中";
			$projectId =  null;
			if ( isset($_GET['pid']))
				$projectId = $_GET['pid'];
			else if ( isset($_POST['pid']))
				$projectId = $_POST['pid'];
			/* project的id没有 */
			if(null === $projectId)
				return $this->denyAccess();
			echo "项目id为:".$projectId;
			return $this->loadProject($projectId);    
        } else {
			return true;
		}
		
    }
	
	/* 如果未确定其project，则不能访问创建页 */
	protected function denyAccess()
    {
        throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
    }
}
