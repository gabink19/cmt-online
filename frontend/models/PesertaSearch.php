<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use frontend\models\Peserta;

/**
 * PesertaSearch represents the model behind the search form of `frontend\models\Peserta`.
 */
class PesertaSearch extends Peserta
{
    public $start_periode;
    public $stop_periode;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tp_id', 'tp_jenis_kelamin', 'tp_flag_active','flag_deleted'], 'integer'],
            [['tp_nik', 'tp_nama_kk', 'tp_nikes', 'tp_status_kel', 'tp_nama_kel', 'tp_hr_pens', 'tp_hr_host', 'tp_band_posisi', 'tp_tgl_lahir', 'tp_umur', 'tp_gol', 'tp_tanggungan', 'tp_tgl_pens', 'tp_tgl_akhir_tanggunngan', 'tp_jenis_peserta', 'tp_no_bpjs','tp_no_telp'], 'safe'],
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
        $query = Peserta::find()->where(['<>', 'flag_deleted', '1']);

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
            'tp_id' => $this->tp_id,
            'tp_tgl_lahir' => $this->tp_tgl_lahir,
            'tp_tgl_pens' => $this->tp_tgl_pens,
            'tp_tgl_akhir_tanggunngan' => $this->tp_tgl_akhir_tanggunngan,
            'tp_jenis_kelamin' => $this->tp_jenis_kelamin,
            'tp_flag_active' => $this->tp_flag_active,
        ]);

        $query->andFilterWhere(['like', 'tp_nik', $this->tp_nik])
            ->andFilterWhere(['like', 'tp_nama_kk', $this->tp_nama_kk])
            ->andFilterWhere(['like', 'tp_nikes', $this->tp_nikes])
            ->andFilterWhere(['like', 'tp_status_kel', $this->tp_status_kel])
            ->andFilterWhere(['like', 'tp_nama_kel', $this->tp_nama_kel])
            ->andFilterWhere(['like', 'tp_hr_pens', $this->tp_hr_pens])
            ->andFilterWhere(['like', 'tp_hr_host', $this->tp_hr_host])
            ->andFilterWhere(['like', 'tp_band_posisi', $this->tp_band_posisi])
            ->andFilterWhere(['like', 'tp_umur', $this->tp_umur])
            ->andFilterWhere(['like', 'tp_gol', $this->tp_gol])
            ->andFilterWhere(['like', 'tp_tanggungan', $this->tp_tanggungan])
            ->andFilterWhere(['like', 'tp_jenis_peserta', $this->tp_jenis_peserta])
            ->andFilterWhere(['like', 'tp_no_bpjs', $this->tp_no_bpjs]);

        return $dataProvider;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function historysearch($params)
    {
        $q = 'SELECT DISTINCT tbs_tp_nikes FROM tbl_billing_final WHERE flag_deleted=0';
        $nikes = ArrayHelper::map(Yii::$app->db->createCommand($q)->queryAll(), 'tbs_tp_nikes', 'tbs_tp_nikes');
        $query = Peserta::find()->where(['IN', 'tp_nikes', $nikes])->andWhere(['<>', 'flag_deleted', '1']);
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

        // echo "<pre>"; print_r($params);echo "</pre>";
        // grid filtering conditions
        $query->andFilterWhere([
            'tp_id' => $this->tp_id,
            'tp_tgl_lahir' => $this->tp_tgl_lahir,
            'tp_tgl_pens' => $this->tp_tgl_pens,
            'tp_tgl_akhir_tanggunngan' => $this->tp_tgl_akhir_tanggunngan,
            'tp_jenis_kelamin' => $this->tp_jenis_kelamin,
            'tp_flag_active' => $this->tp_flag_active,
        ]);

        $query->andFilterWhere(['like', 'tp_nik', $this->tp_nik])
            ->andFilterWhere(['like', 'tp_nama_kk', $this->tp_nama_kk])
            ->andFilterWhere(['like', 'tp_nikes', $this->tp_nikes])
            ->andFilterWhere(['like', 'tp_status_kel', $this->tp_status_kel])
            ->andFilterWhere(['like', 'tp_nama_kel', $this->tp_nama_kel])
            ->andFilterWhere(['like', 'tp_hr_pens', $this->tp_hr_pens])
            ->andFilterWhere(['like', 'tp_hr_host', $this->tp_hr_host])
            ->andFilterWhere(['like', 'tp_band_posisi', $this->tp_band_posisi])
            ->andFilterWhere(['like', 'tp_umur', $this->tp_umur])
            ->andFilterWhere(['like', 'tp_gol', $this->tp_gol])
            ->andFilterWhere(['like', 'tp_tanggungan', $this->tp_tanggungan])
            ->andFilterWhere(['like', 'tp_jenis_peserta', $this->tp_jenis_peserta])
            ->andFilterWhere(['like', 'tp_no_bpjs', $this->tp_no_bpjs]);

        return $dataProvider;
    }
}
