<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Timeline;

/**
 * TimelineSearch represents the model behind the search form about `app\models\Timeline`.
 */
class TimelineSearch extends Timeline
{
    public $username;
    public $robotname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'from', 'to'], 'integer'],
            [['username', 'robotname'], 'safe']
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
        $query = Timeline::find();

        // add conditions that should always apply here

        $query->joinWith(['user', 'robot']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['robotname'] = [
            'asc' => ['robot.name' => SORT_ASC],
            'desc' => ['robot.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'timeline.id' => $this->id,
            'timeline.user_id' => $this->user_id,
            'from' => $this->from,
            'to' => $this->to,
        ]);

        $query->andFilterWhere(['like', 'user.username', $this->username]);
        $query->andFilterWhere(['like', 'robot.name', $this->username]);

        return $dataProvider;
    }
}
