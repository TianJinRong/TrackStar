<?php

/* RecentCommentWidget is a Yii widget used to display a list of recent comments. */

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Comment;
class RecentCommentsWidget extends Widget
{
    private $_comments;
	public $displayLimit = 5;
	public $projectId = null;

    public function init()
    {
        parent::init();
        $this->_comments = $this->findRecentComments($this->displayLimit, $this->projectId);
    }
	
	public function getRecentComments()
	{
		return $this->_comments;
	}

    public function run()
    {
		if(null != $this->RecentComments)
		{
			// var_dump($this->RecentComments);
			return $this->render('recentComments',[
				'comments' => $this->RecentComments,
			]);
		}
			
    }
	
	public function findRecentComments($limit = 10, $projectId = null)
	{
		$comment = new Comment();
		if($projectId != null) {
			// 显示指定项目的最新十条评论
			return $comment->findBySql("SELECT `tbl_comment`.* FROM `tbl_comment`, `tbl_issue` WHERE `tbl_comment`.`issue_id` = `tbl_issue`.`id` AND `tbl_issue`.`project_id` = ".$projectId)->orderBy(['create_time' => SORT_DESC])->limit($limit)->all();
			//return $comment->find()->orderBy(['create_time' => SORT_DESC])->limit($limit)->all();
		} else {
			// 没有指定项目，故显示最新的十条评论
			return $comment->find()->orderBy(['create_time' => SORT_DESC])->limit($limit)->all();
		}
	}
}