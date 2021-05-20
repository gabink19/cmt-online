<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Pendaftaran;

/**
 * PendaftaranSearch represents the model behind the search form of `frontend\models\Pendaftaran`.
 */
class PendaftaranSearch extends Pendaftaran
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['td_id', 'td_tp_id', 'td_flag_status','flag_deleted'], 'integer'],
            [['td_tp_nikes', 'td_tgl_daftar', 'td_rekam_medis', 'td_tujuan', 'td_tp_nik', 'td_umur', 'td_tp_nama_kk', 'td_tp_no_bpjs', 'td_tp_band_posisi', 'td_tp_jenis_peserta', 'td_mitra', 'first_user', 'first_ip', 'last_user', 'last_ip', 'first_date', 'last_date', 'td_path_rujukan', 'td_hak_kelas','td_path_rujukan_2','td_path_rujukan_3'], 'safe'],
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
        $query = Pendaftaran::find()->where(['<>', 'flag_deleted', '1']);

        // add conditions that should always apply here

        if (isset($params['PendaftaranSearch'])) {

            if ($params['PendaftaranSearch']['start_periode'] != "" && $params['PendaftaranSearch']['stop_periode'] != "") {

                $query = $query->andWhere(['between','td_tgl_daftar',$params['PendaftaranSearch']['start_periode'].' 00:00:00',$params['PendaftaranSearch']['stop_periode'].' 23:59:59']);
            }
        }

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
            'td_id' => $this->td_id,
            'td_tp_id' => $this->td_tp_id,
            // 'td_tgl_daftar' => $this->td_tgl_daftar,
            'td_flag_status' => $this->td_flag_status,
            'first_date' => $this->first_date,
            'last_date' => $this->last_date,
        ]);
        // $query->andFilterWhere(['<>', 'flag_deleted', $this->role]);

        $query->andFilterWhere(['like', 'td_tp_nikes', $this->td_tp_nikes])
            ->andFilterWhere(['like', 'td_rekam_medis', $this->td_rekam_medis])
            ->andFilterWhere(['like', 'td_tujuan', $this->td_tujuan])
            ->andFilterWhere(['like', 'td_tp_nik', $this->td_tp_nik])
            ->andFilterWhere(['like', 'td_umur', $this->td_umur])
            ->andFilterWhere(['like', 'td_tp_nama_kk', $this->td_tp_nama_kk])
            ->andFilterWhere(['like', 'td_tp_no_bpjs', $this->td_tp_no_bpjs])
            ->andFilterWhere(['like', 'td_tp_band_posisi', $this->td_tp_band_posisi])
            ->andFilterWhere(['like', 'td_tp_jenis_peserta', $this->td_tp_jenis_peserta])
            ->andFilterWhere(['like', 'td_mitra', $this->td_mitra])
            ->andFilterWhere(['like', 'first_user', $this->first_user])
            ->andFilterWhere(['like', 'first_ip', $this->first_ip])
            ->andFilterWhere(['like', 'last_user', $this->last_user])
            ->andFilterWhere(['like', 'last_ip', $this->last_ip])
            ->andFilterWhere(['like', 'td_path_rujukan', $this->td_path_rujukan])
            ->andFilterWhere(['like', 'td_hak_kelas', $this->td_hak_kelas]);

        $query->orderBy([
            'td_tgl_daftar' => SORT_DESC,
        ]);
        
        return $dataProvider;
    }
}
