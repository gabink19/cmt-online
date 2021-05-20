<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HrPens;

/**
 * HrPensSearch represents the model behind the search form of `backend\models\HrPens`.
 */
class HrPensSearch extends HrPens
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thp_id', 'flag_deleted'], 'integer'],
            [['thp_penamaan', 'thp_keterangan'], 'safe'],
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
        $query = HrPens::find()->where(['<>', 'flag_deleted', '1']);

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
            'thp_id' => $this->thp_id,
            'flag_deleted' => $this->flag_deleted,
        ]);

        $query->andFilterWhere(['like', 'thp_penamaan', $this->thp_penamaan])
            ->andFilterWhere(['like', 'thp_keterangan', $this->thp_keterangan]);

        return $dataProvider;
    }
}
