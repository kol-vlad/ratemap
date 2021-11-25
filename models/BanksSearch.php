<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Banks;

/**
 * BanksSearch represents the model behind the search form of `app\models\Banks`.
 */
class BanksSearch extends Banks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'state', 'pars', 'lrate', 'lratex'], 'integer'],
            [['name', 'icon', 'tel', 'parsurl', 'parsfile', 'time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Banks::find();

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
            'id' => $this->id,
            'state' => $this->state,
            'pars' => $this->pars,
            'lrate' => $this->lrate,
            'lratex' => $this->lratex,
            'time' => $this->time,
          
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'parsurl', $this->parsurl])
            ->andFilterWhere(['like', 'parsfile', $this->parsfile]);

        return $dataProvider;
    }
}
