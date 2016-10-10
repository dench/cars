<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MqttAcl;

/**
 * MqttAclSearch represents the model behind the search form about `app\models\MqttAcl`.
 */
class MqttAclSearch extends MqttAcl
{
    public $username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'rw'], 'integer'],
            [['topic', 'username'], 'safe'],
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
        $query = MqttAcl::find();

        // add conditions that should always apply here

        $query->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'mqtt_acl.id' => $this->id,
            'user_id' => $this->user_id,
            'rw' => $this->rw,
        ]);

        $query->andFilterWhere(['like', 'topic', $this->topic]);
        $query->andFilterWhere(['like', 'user.username', $this->username]);

        return $dataProvider;
    }
}
