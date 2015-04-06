<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "{{%issue}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $project_id
 * @property integer $type_id
 * @property integer $status_id
 * @property integer $owner_id
 * @property integer $requester_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * @property Project $project
 * @property User $owner
 * @property User $requester
 */
class Issue extends \yii\db\ActiveRecord
{
	/* 问题的三种类型 */
	const  TYPE_BUG = 0;
	const  TYPE_FEATURE = 1;
	const  TYPE_TASK = 2;
	
	/* 问题的三种状态 */
    const STATUS_NOT_YET_STARTED = 0;
	const STATUS_STARTED = 1;
	const STATUS_FINISHED = 2;
	
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%issue}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'project_id', 'type_id', 'status_id', 'owner_id', 'requester_id', 'create_time', 'create_user_id', 'update_time', 'update_user_id'], 'required'],
            [['description'], 'string'],
            [['project_id', 'type_id', 'status_id', 'owner_id', 'requester_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 256]
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
            'project_id' => 'Project ID',
            'type_id' => 'Type ID',
            'status_id' => 'Status ID',
            'owner_id' => 'Owner ID',
            'requester_id' => 'Requester ID',
            'create_time' => 'Create Time',
            'create_user_id' => 'Create User ID',
            'update_time' => 'Update Time',
            'update_user_id' => 'Update User ID',
        ];
    }
	


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }
	
	/* 获取issue的所有评论 */
	public function getComments()
	{
		return $this->hasMany(Comment::className(), ['issue_id' => 'id']);
	}
	
	/* 获取issue的所有评论数 */
	public function getCommentCount()
	{
		return $this->comments->count();
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequester()
    {
        return $this->hasOne(User::className(), ['id' => 'requester_id']);
    }
	
	/* 返回问题类型 */
	public function getType()
	{
		switch($this->type_id)
		{
			case $this::TYPE_BUG: return 'Bug'; break;
			case $this::TYPE_FEATURE: return 'Feature'; break;
			case $this::TYPE_TASK: return 'Task'; break;
			default: return 'Unknown type'; break;
		}
	}
	
	/* 返回问题状态 */
	public function getStatus()
	{
		switch($this->status_id)
		{
			case $this::STATUS_NOT_YET_STARTED: return '没开始'; break;
			case $this::STATUS_STARTED: return '进行中'; break;
			case $this::STATUS_FINISHED: return '已结束'; break;
			default: return 'Unknown status'; break;
		}
	}
	
	/* 获取issue的所有类型 */
	public function getTypeOptions() 
	{
		return [
			$this::TYPE_BUG => 'Bug',
			$this::TYPE_FEATURE => 'Feature',
			$this::TYPE_TASK => 'Task',
		];
	}
	
	/* 获取当前issue的所有状态 */
	public function getStatusOptions() 
	{
		return [
			$this::STATUS_NOT_YET_STARTED => '没开始',
			$this::STATUS_STARTED => '进行中',
			$this::STATUS_FINISHED => '已结束',
		];
	}
	
}
