<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CmsPortal;

/**
 * CmsPortalSearch represents the model behind the search form of `backend\models\CmsPortal`.
 */
class CmsPortalSearch extends CmsPortal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['banner1', 'banner2', 'banner3', 'banner4', 'banner5', 'fitur1', 'fitur2', 'fitur3', 'deskripsi', 'deskripsi_img1', 'deskripsi_img2', 'deskripsi_img3', 'deskripsi_text1', 'deskripsi_text2', 'deskripsi_text3', 'partner_img', 'partner_text', 'last_update', 'last_user'], 'safe'],
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
        $query = CmsPortal::find();

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
            'id' => $this->id,
            'last_update' => $this->last_update,
            'last_user' => $this->last_user,
        ]);

        $query->andFilterWhere(['like', 'banner1', $this->banner1])
            ->andFilterWhere(['like', 'banner2', $this->banner2])
            ->andFilterWhere(['like', 'banner3', $this->banner3])
            ->andFilterWhere(['like', 'banner4', $this->banner4])
            ->andFilterWhere(['like', 'banner5', $this->banner5])
            ->andFilterWhere(['like', 'fitur1', $this->fitur1])
            ->andFilterWhere(['like', 'fitur2', $this->fitur2])
            ->andFilterWhere(['like', 'fitur3', $this->fitur3])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'deskripsi_img1', $this->deskripsi_img1])
            ->andFilterWhere(['like', 'deskripsi_img2', $this->deskripsi_img2])
            ->andFilterWhere(['like', 'deskripsi_img3', $this->deskripsi_img3])
            ->andFilterWhere(['like', 'deskripsi_text1', $this->deskripsi_text1])
            ->andFilterWhere(['like', 'deskripsi_text2', $this->deskripsi_text2])
            ->andFilterWhere(['like', 'deskripsi_text3', $this->deskripsi_text3])
            ->andFilterWhere(['like', 'partner_img', $this->partner_img])
            ->andFilterWhere(['like', 'partner_text', $this->partner_text]);

        return $dataProvider;
    }
}
