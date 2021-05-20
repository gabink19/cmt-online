<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Golongan;

/**
 * GolonganSearch represents the model behind the search form of `backend\models\Golongan`.
 */
class GolonganSearch extends Golongan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tg_id', 'flag_deleted'], 'integer'],
            [['tg_penamaan', 'tg_keterangan'], 'safe'],
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
        $query = Golongan::find()->where(['<>', 'flag_deleted', '1']);

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
            'tg_id' => $this->tg_id,
            'flag_deleted' => $this->flag_deleted,
        ]);

        $query->andFilterWhere(['like', 'tg_penamaan', $this->tg_penamaan])
            ->andFilterWhere(['like', 'tg_keterangan', $this->tg_keterangan]);

        return $dataProvider;
    }
}
