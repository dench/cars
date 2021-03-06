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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mqtt_id', 'rw'], 'integer'],
            [['topic'], 'safe'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'mqtt_acl.id' => $this->id,
            'mqtt_id' => $this->mqtt_id,
            'rw' => $this->rw,
        ]);

        $query->andFilterWhere(['like', 'topic', $this->topic]);

        return $dataProvider;
    }
}
