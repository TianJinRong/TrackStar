<?php
namespace app\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class TrackStarActiveRecord extends \yii\db\ActiveRecord
{
	/**
	* Prepares create_time, create_user_id, update_time and
	* update_user_ id attributes before performing validation.
	*/
	public function beforeValidate() {
		/* 设定时区为上海 */
		date_default_timezone_set('Asia/Shanghai');
		if ($this->isNewRecord) {
			// set the create date, last updated date
			// and the user doing the creating
			
			$this->create_time = $this->update_time =  date('Y-m-d H:m:s');
			$this->create_user_id = $this->update_user_id = Yii::$app->user->id;
		}  else {
			//not a new record, so just set the last updated time
			//and last updated user id
			$this->update_time =  date('Y-m-d H:m:s');
			$this->update_user_id = Yii::$app->user->id;
		}
		return parent::beforeValidate();
	}
}
