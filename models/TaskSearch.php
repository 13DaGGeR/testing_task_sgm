<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * TaskSearch represents the model behind the search form about `app\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'owner_id', 'status', 'is_deleted'], 'integer'],
            [['name', 'creation_date', 'description', 'deadline'], 'safe'],
        ];
    }

 	/**
	 * Creates data provider instance with search query applied
	 * @param array $params
	 * @return ActiveDataProvider
	 */
	public function search($params) {
		$query = Task::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params,'');

		if (!$this->validate()) {
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id' => $this->id,
			'creation_date' => $this->creation_date,
			'project_id' => $this->project_id,
			'owner_id' => $this->owner_id,
			'status' => $this->status,
			'deadline' => $this->deadline,
			'is_deleted' => $this->is_deleted,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
				->andFilterWhere(['like', 'description', $this->description]);

		return $dataProvider;
	}
}
