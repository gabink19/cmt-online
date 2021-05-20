<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\HakKelas;

/**
 * HakKelasSearch represents the model behind the search form of `backend\models\HakKelas`.
 */
class HakKelasSearch extends HakKelas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thk_id', 'id_user', 'flag_active', 'flag_deleted'], 'integer'],
            [['thk_rumah_sakit', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII'], 'safe'],
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
        $query = HakKelas::find()->where(['<>', 'flag_deleted', '1']);

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
            'thk_id' => $this->thk_id,
            'id_user' => $this->id_user,
            'flag_active' => $this->flag_active,
            'flag_deleted' => $this->flag_deleted,
        ]);

        $query->andFilterWhere(['like', 'thk_rumah_sakit', $this->thk_rumah_sakit])
            ->andFilterWhere(['like', 'I', $this->I])
            ->andFilterWhere(['like', 'II', $this->II])
            ->andFilterWhere(['like', 'III', $this->III])
            ->andFilterWhere(['like', 'IV', $this->IV])
            ->andFilterWhere(['like', 'V', $this->V])
            ->andFilterWhere(['like', 'VI', $this->VI])
            ->andFilterWhere(['like', 'VII', $this->VII]);

        return $dataProvider;
    }
}
