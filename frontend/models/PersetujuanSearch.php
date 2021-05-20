<?php

namespace frontend\models;
use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Persetujuan;

/**
 * PersetujuanSearch represents the model behind the search form of `frontend\models\Persetujuan`.
 */
class PersetujuanSearch extends Persetujuan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tpt_id', 'tpt_td_id','flag_deleted'], 'integer'],
            [['tpt_tp_nikes', 'tpt_catatan_mitra', 'tpt_path_permintaan_tindak', 'tpt_flag_status', 'tpt_id_user_backend', 'tpt_catatan_yakes', 'tpt_id_user_frontend', 'tpt_nama_mitra', 'tpt_nama_user_backend', 'tgl_permintaan', 'tgl_persetujuan', 'first_ip_backend', 'last_ip_backend', 'first_ip_frontend', 'last_ip_frontend', 'first_date_backend', 'last_date_backend', 'first_date_frontend', 'last_date_frontend', 'first_user_backend', 'last_user_backend', 'first_user_frontend', 'last_user_frontend'], 'safe'],
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
        $query = Persetujuan::find()->where(['<>', 'flag_deleted', '1']);

        // add conditions that should always apply here
        if (isset($params['PersetujuanSearch'])) {

            if ($params['PersetujuanSearch']['start_periode'] != "" && $params['PersetujuanSearch']['stop_periode'] != "") {

                $query = $query->andWhere(['between','tgl_permintaan',$params['PersetujuanSearch']['start_periode'].' 00:00:00',$params['PersetujuanSearch']['stop_periode'].' 23:59:59']);
            }

             if($params['PersetujuanSearch']['tujuan'] != ""){
                $sql = "SELECT td_id from tbl_daftar where td_tujuan = '".$params['PersetujuanSearch']['tujuan']."'";
                $dataId = Yii::$app->db->createCommand($sql)->queryAll();
                foreach ($dataId as $key => $value) {
                    $newp[]=$value['td_id'];
                }
                // $ids = implode(',', $newp);
                $query = $query->andWhere(['in','tpt_td_id',$newp]);
            }
            // tpt_td_id
        }
        if (!isset($params['PersetujuanSearch']['start_periode'])) {
            $query = $query->andWhere(['between','tgl_permintaan',date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59']);
        }
        // echo "<pre>";
        // print_r($query);
        // echo "</pre>";
        // die();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (Yii::$app->user->identity->rs_mitra!='' && Yii::$app->user->identity->bidang_mitra != 9) {
            $query->andFilterWhere(['like', 'tpt_nama_mitra', Yii::$app->user->identity->rs_mitra]);
        }else{
            $query->andFilterWhere(['like', 'tpt_nama_mitra', $this->tpt_nama_mitra]);
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'tpt_id' => $this->tpt_id,
            'tpt_td_id' => $this->tpt_td_id,
            'tpt_flag_status'=> $this->tpt_flag_status,
        ]);

        $query->andFilterWhere(['like', 'tpt_tp_nikes', $this->tpt_tp_nikes])
            ->andFilterWhere(['like', 'tpt_catatan_mitra', $this->tpt_catatan_mitra])
            ->andFilterWhere(['like', 'tpt_path_permintaan_tindak', $this->tpt_path_permintaan_tindak])
            ->andFilterWhere(['like', 'tpt_flag_status', $this->tpt_flag_status])
            ->andFilterWhere(['like', 'tpt_id_user_backend', $this->tpt_id_user_backend])
            ->andFilterWhere(['like', 'tpt_catatan_yakes', $this->tpt_catatan_yakes])
            ->andFilterWhere(['like', 'tpt_id_user_frontend', $this->tpt_id_user_frontend])
            // ->andFilterWhere(['like', 'tpt_nama_mitra', $this->tpt_nama_mitra])
            ->andFilterWhere(['like', 'tpt_nama_user_backend', $this->tpt_nama_user_backend])
            ->andFilterWhere(['like', 'first_ip_backend', $this->first_ip_backend])
            ->andFilterWhere(['like', 'last_ip_backend', $this->last_ip_backend])
            ->andFilterWhere(['like', 'first_ip_frontend', $this->first_ip_frontend])
            ->andFilterWhere(['like', 'last_ip_frontend', $this->last_ip_frontend])
            ->andFilterWhere(['like', 'first_user_backend', $this->first_user_backend])
            ->andFilterWhere(['like', 'last_user_backend', $this->last_user_backend])
            ->andFilterWhere(['like', 'first_user_frontend', $this->first_user_frontend])
            ->andFilterWhere(['like', 'last_user_frontend', $this->last_user_frontend]);

        $query->orderBy([
            'tgl_permintaan' => SORT_DESC,
        ]);

        return $dataProvider;
    }
    public function historysearch($params)
    {
        $query = Persetujuan::find()->where(['<>', 'flag_deleted', '1'])->orderBy('tpt_id ASC');
        // $query = Persetujuan::find()->where(['<>', 'flag_deleted', '1'])->groupBy('tpt_uniq_code')->orderBy('tpt_id DESC');

        // add conditions that should always apply here
        if (isset($params['PersetujuanSearch'])) {

            if ($params['PersetujuanSearch']['start_periode'] != "" && $params['PersetujuanSearch']['stop_periode'] != "") {

                $query = $query->andWhere(['between','tgl_permintaan',$params['PersetujuanSearch']['start_periode'].' 00:00:00',$params['PersetujuanSearch']['stop_periode'].' 23:59:59']);
            }

             if($params['PersetujuanSearch']['tujuan'] != ""){
                $sql = "SELECT td_id from tbl_daftar where td_tujuan = '".$params['PersetujuanSearch']['tujuan']."'";
                $dataId = Yii::$app->db->createCommand($sql)->queryAll();
                foreach ($dataId as $key => $value) {
                    $newp[]=$value['td_id'];
                }
                // $ids = implode(',', $newp);
                $query = $query->andWhere(['in','tpt_td_id',$newp]);
            }
            // tpt_td_id
        }
        if (!isset($params['PersetujuanSearch']['start_periode'])) {
            $query = $query->andWhere(['between','tgl_permintaan',date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59']);
        }
        // echo "<pre>";
        // print_r($query);
        // echo "</pre>";
        // die();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (Yii::$app->user->identity->rs_mitra!='' && Yii::$app->user->identity->bidang_mitra != 9) {
            $query->andFilterWhere(['like', 'tpt_nama_mitra', Yii::$app->user->identity->rs_mitra]);
        }else{
            $query->andFilterWhere(['like', 'tpt_nama_mitra', $this->tpt_nama_mitra]);
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'tpt_id' => $this->tpt_id,
            'tpt_td_id' => $this->tpt_td_id,
            'tpt_flag_status'=> $this->tpt_flag_status,
        ]);

        $query->andFilterWhere(['like', 'tpt_tp_nikes', $this->tpt_tp_nikes])
            ->andFilterWhere(['like', 'tpt_catatan_mitra', $this->tpt_catatan_mitra])
            ->andFilterWhere(['like', 'tpt_path_permintaan_tindak', $this->tpt_path_permintaan_tindak])
            ->andFilterWhere(['like', 'tpt_flag_status', $this->tpt_flag_status])
            ->andFilterWhere(['like', 'tpt_id_user_backend', $this->tpt_id_user_backend])
            ->andFilterWhere(['like', 'tpt_catatan_yakes', $this->tpt_catatan_yakes])
            ->andFilterWhere(['like', 'tpt_id_user_frontend', $this->tpt_id_user_frontend])
            // ->andFilterWhere(['like', 'tpt_nama_mitra', $this->tpt_nama_mitra])
            ->andFilterWhere(['like', 'tpt_nama_user_backend', $this->tpt_nama_user_backend])
            ->andFilterWhere(['like', 'first_ip_backend', $this->first_ip_backend])
            ->andFilterWhere(['like', 'last_ip_backend', $this->last_ip_backend])
            ->andFilterWhere(['like', 'first_ip_frontend', $this->first_ip_frontend])
            ->andFilterWhere(['like', 'last_ip_frontend', $this->last_ip_frontend])
            ->andFilterWhere(['like', 'first_user_backend', $this->first_user_backend])
            ->andFilterWhere(['like', 'last_user_backend', $this->last_user_backend])
            ->andFilterWhere(['like', 'first_user_frontend', $this->first_user_frontend])
            ->andFilterWhere(['like', 'last_user_frontend', $this->last_user_frontend]);

        return $dataProvider;
    }
    public function historysearchChild($params,$uniq_code,$id)
    {
        $query = Persetujuan::find()->where("flag_deleted = 0 and tpt_uniq_code = '$uniq_code' and tpt_id <> $id")
                ->orderBy('tgl_persetujuan DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (Yii::$app->user->identity->rs_mitra!='' && Yii::$app->user->identity->bidang_mitra != 9) {
            $query->andFilterWhere(['like', 'tpt_nama_mitra', Yii::$app->user->identity->rs_mitra]);
        }else{
            $query->andFilterWhere(['like', 'tpt_nama_mitra', $this->tpt_nama_mitra]);
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'tpt_id' => $this->tpt_id,
            'tpt_td_id' => $this->tpt_td_id,
            'tpt_flag_status'=> $this->tpt_flag_status,
        ]);


        $query->orderBy([
            'tgl_permintaan' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}
