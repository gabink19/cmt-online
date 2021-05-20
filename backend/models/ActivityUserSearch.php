<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ActivityUser;

/**
 * ActivityUserSearch represents the model behind the search form of `backend\models\ActivityUser`.
 */
class ActivityUserSearch extends ActivityUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['tanggal', 'berita', 'username', 'ip'], 'safe'],
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
        $query = ActivityUser::find()->orderBy(['tanggal'=>SORT_DESC]);

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

        if (isset($params['ActivityUserSearch'])) {

            if ($params['ActivityUserSearch']['start_periode'] != "" && $params['ActivityUserSearch']['stop_periode'] != "") {

                $query = $query->andWhere(['between','tanggal',$params['ActivityUserSearch']['start_periode'].' 00:00:00',$params['ActivityUserSearch']['stop_periode'].' 23:59:59']);
            }
        }
        if (!isset($params['ActivityUserSearch']['start_periode'])) {
            $query = $query->andWhere(['between','tanggal',date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59']);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'tanggal' => $this->tanggal,
        ]);

        $query->andFilterWhere(['like', 'berita', $this->berita])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
