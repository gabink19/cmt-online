<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\JenisPeserta;

/**
 * JenisPesertaSearch represents the model behind the search form of `backend\models\JenisPeserta`.
 */
class JenisPesertaSearch extends JenisPeserta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tjp_id', 'flag_deleted'], 'integer'],
            [['tjp_penamaan', 'tjp_keterangan'], 'safe'],
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
        $query = JenisPeserta::find()->where(['<>', 'flag_deleted', '1']);

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
            'tjp_id' => $this->tjp_id,
            'flag_deleted' => $this->flag_deleted,
        ]);

        $query->andFilterWhere(['like', 'tjp_penamaan', $this->tjp_penamaan])
            ->andFilterWhere(['like', 'tjp_keterangan', $this->tjp_keterangan]);

        return $dataProvider;
    }
}
