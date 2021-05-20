<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Bidang;

/**
 * BidangSearch represents the model behind the search form of `backend\models\Bidang`.
 */
class BidangSearch extends Bidang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tb_id', 'tb_flag_akses', 'flag_deleted'], 'integer'],
            [['tb_nama_bidang', 'tb_keterangan'], 'safe'],
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
        $query = Bidang::find();

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
            'tb_id' => $this->tb_id,
            'tb_flag_akses' => $this->tb_flag_akses,
            'flag_deleted' => 0,
        ]);

        $query->andFilterWhere(['like', 'tb_nama_bidang', $this->tb_nama_bidang])
            ->andFilterWhere(['like', 'tb_keterangan', $this->tb_keterangan]);

        return $dataProvider;
    }
}
