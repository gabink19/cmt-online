<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PersetujuanTindak;
use Yii;

/**
 * PersetujuanTindakSearch represents the model behind the search form of `backend\models\PersetujuanTindak`.
 */
class PersetujuanTindakSearch extends PersetujuanTindak
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tpt_id', 'tpt_td_id', 'flag_deleted', 'tpt_diagnosa'], 'integer'],
            [['tpt_uniq_code', 'tpt_tp_nikes', 'tpt_catatan_mitra', 'tpt_path_permintaan_tindak', 'tpt_flag_status', 'tpt_id_user_backend', 'tpt_catatan_yakes', 'tpt_id_user_frontend', 'tpt_nama_mitra', 'tpt_nama_user_backend', 'tgl_permintaan', 'tgl_persetujuan', 'first_ip_backend', 'last_ip_backend', 'first_ip_frontend', 'last_ip_frontend', 'first_date_backend', 'last_date_backend', 'first_date_frontend', 'last_date_frontend', 'first_user_backend', 'last_user_backend', 'first_user_frontend', 'last_user_frontend', 'history_note'], 'safe'],
            [['biaya', 'biaya_disetujui'], 'number'],
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
        $query = PersetujuanTindak::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if(empty($params['PersetujuanTindakSearch'])){
            $query = $query->andWhere(['between','tgl_permintaan',"1970-01-01 00:00:00","1970-01-01 23:59:59"]);            
        }
        
        if(!empty($params['PersetujuanTindakSearch']['priode'])){
            $tipe = $params['PersetujuanTindakSearch']['priode'];
            if($tipe == 1){ //perbulan
                // $sampe = strtotime('30 days');
                $start = $params['PersetujuanTindakSearch']['start_periode'];
                $stop = $params['PersetujuanTindakSearch']['stop_periode'];

                $query = $query->andWhere(['between','tgl_permintaan',$start."-01 00:00:00",$stop."-31 23:59:59"]);
            }
            if($tipe == 2){ //pertriwulan
                $tahun = $params['PersetujuanTindakSearch']['tahuntri'];
                $month = $params['PersetujuanTindakSearch']['triwulan'];
                $date = $this->triwulan($month, $tahun);

                $query = $query->andWhere(['between','tgl_permintaan', $date[0], $date[1]]);
                
            }
            if($tipe == 3){ //pertahun
                $start = $params['PersetujuanTindakSearch']['start_periode2'];
                $stop = $params['PersetujuanTindakSearch']['stop_periode2'];

                $query = $query->andWhere(['between','tgl_permintaan',$start.'-01-01 00:00:00',$stop.'-12-31 23:59:59']);
            }

        }
        if(!empty($params['PersetujuanTindakSearch']['approve'])){
            $this->last_user_backend = $params['PersetujuanTindakSearch']['approve'];
        }
        if(!empty($params['PersetujuanTindakSearch']['status'])){
            $status = $params['PersetujuanTindakSearch']['status'];
            $sqlS = "SELECT td_id from tbl_daftar WHERE td_flag_status ='".$status."'";
            if($status == 2){
                $sqlS = "SELECT td_id from tbl_daftar WHERE td_flag_status in (2,3,4)";
            }
            $dbS = Yii::$app->db->createCommand($sqlS)->queryAll();
            foreach ($dbS as $key => $db) {
                $data[]= $db['td_id'];
            }
        }
        if(($params['PersetujuanTindakSearch']['tujuan']) != ""){
            $tujuan = $params['PersetujuanTindakSearch']['tujuan'];
            $sql = "SELECT td_id from tbl_daftar WHERE td_tujuan ='".$tujuan."'";

            $db = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($db as $keys => $db2) {
                $data[]= $db2['td_id'];
            }
        }

        if($params['PersetujuanTindakSearch']['tujuan'] != "" && !empty($params['PersetujuanTindakSearch']['status'])){
            unset($data);
            // $tujuan = $params['PersetujuanTindakSearch']['tujuan'];
            $sql = "SELECT td_id from tbl_daftar WHERE td_tujuan ='".$tujuan."' AND td_flag_status ='".$status."'";

            $db = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($db as $keys => $db2) {
                $data[]= $db2['td_id'];
            }
        }

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'tpt_id' => $this->tpt_id,
            'tpt_td_id' => $data,
            'last_user_backend' => $this->last_user_backend,
        ]);

        $query->andFilterWhere(['like', 'tpt_uniq_code', $this->tpt_uniq_code])
            ->andFilterWhere(['like', 'tpt_tp_nikes', $this->tpt_tp_nikes])
            ->andFilterWhere(['like', 'tpt_nama_mitra', $this->tpt_nama_mitra])
            ->andFilterWhere(['like', 'tpt_nama_user_backend', $this->tpt_nama_user_backend])
            ->andFilterWhere(['like', 'last_user_backend', $this->last_user_backend]);
            // echo "<pre>";
            // print_r($query);
            // echo "</pre>";
            // die();

        return $dataProvider;
    }
    public function triwulan($month, $tahun)
    {
        if($month == "01"){
            $start = $tahun."-01-01 00:00:00";
            $stop = $tahun."-03-31 00:00:00";
        }
        if($month == "02"){ 
            $start = $tahun."-04-01 00:00:00";
            $stop = $tahun."-06-31 00:00:00";
        }
        if($month == "03"){
            $start = $tahun."-07-01 00:00:00";
            $stop = $tahun."-09-31 00:00:00";
        }
        if($month == "04"){
            $start = $tahun."-10-01 00:00:00";
            $stop = $tahun."-12-31 00:00:00";
        }

        $array = [$start, $stop];
            
        return $array;
    }
    public function searchSaving($params)
    {
        $query = PersetujuanTindak::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if(empty($params['PersetujuanTindakSearch'])){
            $query = $query->andWhere(['between','tgl_permintaan',"1970-01-01 00:00:00","1970-01-01 23:59:59"]);            
        }
        
        if(!empty($params['PersetujuanTindakSearch']['priode'])){
            $tipe = $params['PersetujuanTindakSearch']['priode'];
            if($tipe == 1){ //perbulan
                // $sampe = strtotime('30 days');
                $start = $params['PersetujuanTindakSearch']['start_periode'];
                $stop = $params['PersetujuanTindakSearch']['stop_periode'];

                $query = $query->andWhere(['between','tgl_permintaan',$start."-01 00:00:00",$stop."-31 23:59:59"]);
            }
            if($tipe == 2){ //pertriwulan
                $tahun = $params['PersetujuanTindakSearch']['tahuntri'];
                $month = $params['PersetujuanTindakSearch']['triwulan'];
                $date = $this->triwulan($month, $tahun);

                $query = $query->andWhere(['between','tgl_permintaan', $date[0], $date[1]]);
                
            }
            if($tipe == 3){ //pertahun
                $start = $params['PersetujuanTindakSearch']['start_periode2'];
                $stop = $params['PersetujuanTindakSearch']['stop_periode2'];

                $query = $query->andWhere(['between','tgl_permintaan',$start.'-01-01 00:00:00',$stop.'-12-31 23:59:59']);
            }

        }

        if(!empty($params['PersetujuanTindakSearch']['status'])){
            $status = $params['PersetujuanTindakSearch']['status'];
            $sqlS = "SELECT td_id from tbl_daftar WHERE td_flag_status ='".$status."'";
            if($status == 2){
                $sqlS = "SELECT td_id from tbl_daftar WHERE td_flag_status in (2,3,4)";
            }
            $dbS = Yii::$app->db->createCommand($sqlS)->queryAll();
            foreach ($dbS as $key => $db) {
                $data[]= $db['td_id'];
            }
        }
        if(isset($params['PersetujuanTindakSearch']['costsaving'])){
            $saving = $params['PersetujuanTindakSearch']['costsaving'];
            $cost = "*, (biaya_disetujui - case when biaya IS NULL then 'empty' else biaya end) AS cost_saving";
            $query->select($cost);
            if($saving == 9){
                $query->orderBy([
                    'cost_saving' => SORT_DESC,
                ]);
            }
            if($saving == 0){
                $query->orderBy([
                    'cost_saving' => SORT_ASC,
                ]);
            }
        }

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'tpt_id' => $this->tpt_id,
            'tpt_td_id' => $data,
            'tpt_nama_mitra' => $this->tpt_nama_mitra,
            'tpt_diagnosa' => $this->tpt_diagnosa,
        ]);

        $query->andFilterWhere(['like', 'tpt_uniq_code', $this->tpt_uniq_code])
            ->andFilterWhere(['like', 'tpt_tp_nikes', $this->tpt_tp_nikes])
            ->andFilterWhere(['like', 'tpt_nama_mitra', $this->tpt_nama_mitra])
            ->andFilterWhere(['like', 'tpt_nama_user_backend', $this->tpt_nama_user_backend])
            ->andFilterWhere(['like', 'last_user_backend', $this->last_user_backend]);

        return $dataProvider;
    }
}
