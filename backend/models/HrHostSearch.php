<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HrHost;

/**
 * HrHostSearch represents the model behind the search form of `backend\models\HrHost`.
 */
class HrHostSearch extends HrHost
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thh_id', 'flag_deleted'], 'integer'],
            [['thh_penamaan', 'thh_keterangan'], 'safe'],
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
        $query = HrHost::find()->where(['<>', 'flag_deleted', '1']);

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
            'thh_id' => $this->thh_id,
            'flag_deleted' => $this->flag_deleted,
        ]);

        $query->andFilterWhere(['like', 'thh_penamaan', $this->thh_penamaan])
            ->andFilterWhere(['like', 'thh_keterangan', $this->thh_keterangan]);

        return $dataProvider;
    }
}
