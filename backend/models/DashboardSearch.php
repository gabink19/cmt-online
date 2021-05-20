<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dashboard;

/**
 * DashboardSearch represents the model behind the search form of `app\models\Dashboard`.
 */
class DashboardSearch extends Dashboard
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ttd_id', 'flag_deleted'], 'integer'],
            [['ttd_penamaan', 'ttd_deskripsi', 'ttd_tdg_kode'], 'safe'],
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
        $query = Dashboard::find();

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
            'ttd_id' => $this->ttd_id,
            'flag_deleted' => $this->flag_deleted,
        ]);

        $query->andFilterWhere(['like', 'ttd_penamaan', $this->ttd_penamaan])
            ->andFilterWhere(['like', 'ttd_deskripsi', $this->ttd_deskripsi])
            ->andFilterWhere(['like', 'ttd_tdg_kode', $this->ttd_tdg_kode]);

        return $dataProvider;
    }
}
