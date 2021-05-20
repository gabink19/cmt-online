<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Rujukan;

/**
 * RujukanSearch represents the model behind the search form of `frontend\models\Rujukan`.
 */
class RujukanSearch extends Rujukan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tr_td_id'], 'integer'],
            [['tr_no_regis', 'tr_no_rujukan', 'tr_tujuan', 'tr_nama_dokter', 'tr_nama_pasien', 'tr_umur', 'tr_nikes', 'tr_nama_kk', 'tr_band', 'tr_hak_kelas', 'tr_anamnese', 'tr_diagnosa', 'tr_tindakan', 'tr_tgl_rujukan', 'tr_nama_jaminan', 'flag_deleted', 'path_file', 'date_create'], 'safe'],
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
        $query = Rujukan::find();

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
            'tr_tgl_rujukan' => $this->tr_tgl_rujukan,
            'tr_td_id' => $this->tr_td_id,
            'date_create' => $this->date_create,
        ]);

        $query->andFilterWhere(['like', 'tr_no_regis', $this->tr_no_regis])
            ->andFilterWhere(['like', 'tr_no_rujukan', $this->tr_no_rujukan])
            ->andFilterWhere(['like', 'tr_tujuan', $this->tr_tujuan])
            ->andFilterWhere(['like', 'tr_nama_dokter', $this->tr_nama_dokter])
            ->andFilterWhere(['like', 'tr_nama_pasien', $this->tr_nama_pasien])
            ->andFilterWhere(['like', 'tr_umur', $this->tr_umur])
            ->andFilterWhere(['like', 'tr_nikes', $this->tr_nikes])
            ->andFilterWhere(['like', 'tr_nama_kk', $this->tr_nama_kk])
            ->andFilterWhere(['like', 'tr_band', $this->tr_band])
            ->andFilterWhere(['like', 'tr_hak_kelas', $this->tr_hak_kelas])
            ->andFilterWhere(['like', 'tr_anamnese', $this->tr_anamnese])
            ->andFilterWhere(['like', 'tr_diagnosa', $this->tr_diagnosa])
            ->andFilterWhere(['like', 'tr_tindakan', $this->tr_tindakan])
            ->andFilterWhere(['like', 'tr_nama_jaminan', $this->tr_nama_jaminan])
            ->andFilterWhere(['like', 'flag_deleted', $this->flag_deleted])
            ->andFilterWhere(['like', 'path_file', $this->path_file]);

        return $dataProvider;
    }
}
