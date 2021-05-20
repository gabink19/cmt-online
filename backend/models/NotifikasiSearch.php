<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Notifikasi;

/**
 * NotifikasiSearch represents the model behind the search form of `backend\models\Notifikasi`.
 */
class NotifikasiSearch extends Notifikasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tn_id', 'tn_kepada', 'tn_user_mitra', 'tn_type_notif', 'tn_telah_dikirim', 'tn_telah_dibaca', 'tn_tipe_notif', 'tn_user_id','flag_deleted'], 'integer'],
            [['tn_tanggal', 'tn_judul', 'tn_teks', 'tn_link', 'tn_dibaca_tanggal'], 'safe'],
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
        $query = Notifikasi::find()->where(['<>', 'flag_deleted', '1']);

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
            'tn_id' => $this->tn_id,
            'tn_kepada' => $this->tn_kepada,
            'tn_user_mitra' => $this->tn_user_mitra,
            'tn_tanggal' => $this->tn_tanggal,
            'tn_type_notif' => $this->tn_type_notif,
            'tn_telah_dikirim' => $this->tn_telah_dikirim,
            'tn_telah_dibaca' => $this->tn_telah_dibaca,
            'tn_tipe_notif' => $this->tn_tipe_notif,
            'tn_user_id' => $this->tn_user_id,
            'tn_dibaca_tanggal' => $this->tn_dibaca_tanggal,
        ]);

        $query->andFilterWhere(['like', 'tn_judul', $this->tn_judul])
            ->andFilterWhere(['like', 'tn_teks', $this->tn_teks])
            ->andFilterWhere(['like', 'tn_link', $this->tn_link]);

        return $dataProvider;
    }
}
