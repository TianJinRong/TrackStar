<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\ProjectUserRole;
use app\models\ProjectUserAssignment;
/**
 * This is the model class for table "{{%project}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property Issue[] $issues
 * @property ProjectUserAssignment[] $projectUserAssignments
 * @property User[] $users
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'create_time', 'create_user_id', 'update_time', 'update_user_id'], 'required'],
            [['description'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['create_user_id', 'update_user_id'], 'integer'],
            [['name'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'create_time' => 'Create Time',
            'create_user_id' => 'Create User ID',
            'update_time' => 'Update Time',
            'update_user_id' => 'Update User ID',
        ];
    }
	


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasMany(Issue::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUserAssignments()
    {
        return $this->hasMany(ProjectUserAssignment::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('{{%project_user_assignment}}', ['project_id' => 'id']);
    }
	
	public function getUserOptions()
	{
		$userArray = ArrayHelper::map($this->users, 'id', 'username');
		return $userArray;
	}
	
	
	
	// 将本项目关联用户
	public function associateUserToProject($user)
	{
		$ProjectUserAssignment = new ProjectUserAssignment();
		$ProjectUserAssignment->project_id = $this->id;
		$ProjectUserAssignment->user_id = $user->id;		
		return $ProjectUserAssignment->save();
	}
	
	// 在本项目中设定当前用户的角色
	public function associateUserToRole($rolename, $userId)
	{
		$authorize = new ProjectUserRole();
		$authorize->project_id = $this->id;
		$authorize->user_id = $userId;
		$authorize->role = $rolename;
		
		return $authorize->save();
	}
	
	// 在本项目中移除当前用户的角色
	public function removeUserFromRole($rolename, $userId)
	{
		$authorize = ProjectUserRole::find()->where([
			'project_id' => $this->id,
			'user_id' => $userId,
			'role' => $rolename
		])->one();		
		return $authorize->delete();
	}
	
	// 判断本项目中是否有当前用户的角色
	public function isUserInRole($rolename)
	{
		$authorize = ProjectUserRole::find(['role'])->where([
			'project_id' => $this->id,
			'user_id' => Yii::$app->user->id,
			'role' => $rolename
		])->exists();		
		return $authorize;
	}
	
	// 判断用户是否已经与项目关联
	public function isUserInProject($user)
	{
		$isUserInProject = ProjectUserAssignment::find()->where([
			'project_id' => $this->id,
			'user_id' => $user->id
		])->exists();		
		return $isUserInProject;
	}
}
