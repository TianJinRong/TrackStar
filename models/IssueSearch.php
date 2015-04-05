<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Issue;

/**
 * IssueSearch represents the model behind the search form about `app\models\Issue`.
 */
class IssueSearch extends Issue
{	
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'type_id', 'status_id', 'owner_id', 'requester_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['name', 'description', 'create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
		$issueProjectId = 0;
		/* 确定要读取的是哪一个项目的issues */
		if(null === $this->project_id)
		{
			/* 若没有指明要显示的是哪一个项目的issues
			 * 就只显示第一个项目的issue */
			 
			/* 获取第一个issue */
			$firstIssue = Issue::find()->one();
			/* 获取第一个issue的项目id */
			$issueProjectId = $firstIssue->project_id;
		}	
		else
		{
			/* 若指明了要显示的是哪一个项目的issues
			 * 就显示该项目的issues */
			$issueProjectId = $this->project_id;
		}
		// 无法通过，会出现"Call to a member function andFilterWhere() on a non-object"的错误
		// $query = Issue::find()->where(['project_id' => $issueProjectId,])->all(); 
		$query = Issue::find()->where(['project_id' => $issueProjectId,]); 
		
		
		/* 测试 */
		//var_dump($query);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id,
            'type_id' => $this->type_id,
            'status_id' => $this->status_id,
            'owner_id' => $this->owner_id,
            'requester_id' => $this->requester_id,
            'create_time' => $this->create_time,
            'create_user_id' => $this->create_user_id,
            'update_time' => $this->update_time,
            'update_user_id' => $this->update_user_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
