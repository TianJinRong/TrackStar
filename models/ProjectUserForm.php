<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
class ProjectUserForm extends Model
{
    public $username;
    public $rolename;
    public $project;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and rolename are both required
            [['username', 'rolename'], 'required'],
            // username is validated by validateUsername()
            ['username', 'validateUsername'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUsername($attribute, $params)
    {
		// 查找该用户是否存在
        if (!$this->hasErrors()) {
            $user = $this->user;

            if (!$user) {
                $this->addError($attribute, '该用户不存在！');
            } else if($this->project->isUserInProject($user))
			{
				$this->addError($attribute, '该用户已与本项目关联！');
			} else
			{
				// 关联并授权
				$this->project->associateUserToProject($user);
				$this->project->associateUserToRole($this->rolename, $user->id);
				$auth = Yii::$app->authManager;
				$role = $auth->getRole($this->rolename);
				if(isset($params['project']) && $params['project']->isUserInRole($this->rolename))
				{
					$auth->assign($role, $user->id);
				}				
			}
        }
    }
	
	/* 获取可选的角色清单 */
	public function getUserRoleOptions()
	{
		return ArrayHelper::map(Yii::$app->authManager->roles, 'name', 'name');
	}
	
	/* 获取可选的用户清单 */
	public function getUsernameOptions()
	{
		return ArrayHelper::map(User::find()->all(), 'username', 'username');
	}

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
			/* 通过usercontroller来查看该user是否存在 */
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
