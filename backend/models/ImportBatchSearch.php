<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ImportBatch;

/**
 * ImportBatchSearch represents the model behind the search form of `backend\models\ImportBatch`.
 */
class ImportBatchSearch extends ImportBatch
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tib_id', 'tib_total', 'tib_success', 'tib_failed'], 'integer'],
            [['tib_filename', 'tib_status', 'tib_date', 'first_user'], 'safe'],
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
        $query = ImportBatch::find();

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
            'tib_id' => $this->tib_id,
            'tib_date' => $this->tib_date,
            'tib_total' => $this->tib_total,
            'tib_success' => $this->tib_success,
            'tib_failed' => $this->tib_failed,
        ]);

        $query->andFilterWhere(['like', 'tib_filename', $this->tib_filename])
            ->andFilterWhere(['like', 'tib_status', $this->tib_status])
            ->andFilterWhere(['like', 'first_user', $this->first_user]);

        return $dataProvider;
    }
}
