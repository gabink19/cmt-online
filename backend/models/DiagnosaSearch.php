<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Diagnosa;

/**
 * DiagnosaSearch represents the model behind the search form of `backend\models\Diagnosa`.
 */
class DiagnosaSearch extends Diagnosa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tdg_id', 'flag_deleted'], 'integer'],
            [['tdg_penamaan', 'tdg_keterangan', 'tdg_kode'], 'safe'],
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
        $query = Diagnosa::find()->where(['<>', 'flag_deleted', '1']);

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
            'tdg_id' => $this->tdg_id,
            'flag_deleted' => $this->flag_deleted,
        ]);

        $query->andFilterWhere(['like', 'tdg_penamaan', $this->tdg_penamaan])
            ->andFilterWhere(['like', 'tdg_keterangan', $this->tdg_keterangan])
            ->andFilterWhere(['like', 'tdg_kode', $this->tdg_kode]);

        return $dataProvider;
    }
}
