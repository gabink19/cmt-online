<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BandPosisi;

/**
 * BandPosisiSearch represents the model behind the search form of `backend\models\BandPosisi`.
 */
class BandPosisiSearch extends BandPosisi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tbp_id', 'flag_deleted'], 'integer'],
            [['tbp_penamaan', 'tbp_keterangan'], 'safe'],
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
        $query = BandPosisi::find()->where(['<>', 'flag_deleted', '1']);

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
            'tbp_id' => $this->tbp_id,
            'flag_deleted' => $this->flag_deleted,
        ]);

        $query->andFilterWhere(['like', 'tbp_penamaan', $this->tbp_penamaan])
            ->andFilterWhere(['like', 'tbp_keterangan', $this->tbp_keterangan]);

        return $dataProvider;
    }
}
