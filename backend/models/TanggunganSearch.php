<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tanggungan;

/**
 * TanggunganSearch represents the model behind the search form of `backend\models\Tanggungan`.
 */
class TanggunganSearch extends Tanggungan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tt_id', 'flag_deleted'], 'integer'],
            [['tt_penamaan', 'tt_keterangan'], 'safe'],
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
        $query = Tanggungan::find()->where(['<>', 'flag_deleted', '1']);

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
            'tt_id' => $this->tt_id,
            'flag_deleted' => $this->flag_deleted,
        ]);

        $query->andFilterWhere(['like', 'tt_penamaan', $this->tt_penamaan])
            ->andFilterWhere(['like', 'tt_keterangan', $this->tt_keterangan]);

        return $dataProvider;
    }
}
