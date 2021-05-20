<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReportLos;
use Yii;

/**
 * ReportLosSearch represents the model behind the search form of `app\models\ReportLos`.
 */
class ReportLosSearch extends ReportLos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tbs_id', 'tbs_td_id', 'flag_deleted', 'tbs_diagnosa'], 'integer'],
            [['tbs_tp_nikes', 'tbs_catatan_mitra', 'tbs_path_billing', 'tbs_flag_status', 'tbs_id_user_backend', 'tbs_catatan_yakes', 'tbs_id_user_frontend', 'tbs_nama_mitra', 'tbs_nama_user_backend', 'tgl_billing', 'tgl_billing_diresponse', 'first_ip_backend', 'last_ip_backend', 'first_ip_frontend', 'last_ip_frontend', 'first_date_backend', 'last_date_backend', 'first_date_frontend', 'last_date_frontend', 'first_user_backend', 'last_user_backend', 'first_user_frontend', 'last_user_frontend'], 'safe'],
            [['tbs_biaya'], 'number'],
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
        $query = ReportLos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if(empty($params['ReportLosSearch'])){
            $query = $query->andWhere(['between','tgl_billing',"1970-01-01 00:00:00","1970-01-01 23:59:59"]);            
        }
        if(!empty($params['ReportLosSearch']['priode'])){
            $tipe = $params['ReportLosSearch']['priode'];
            if($tipe == 1){ //perbulan
                // $sampe = strtotime('30 days');
                $start = $params['ReportLosSearch']['start_periode'];
                $stop = $params['ReportLosSearch']['stop_periode'];

                $query = $query->andWhere(['between','tgl_billing',$start."-01 00:00:00",$stop."-31 23:59:59"]);
            }
            if($tipe == 2){ //pertriwulan
                $tahun = $params['ReportLosSearch']['tahuntri'];
                $month = $params['ReportLosSearch']['triwulan'];
                $date = $this->triwulan($month, $tahun);

                $query = $query->andWhere(['between','tgl_billing', $date[0], $date[1]]);
                
            }
            if($tipe == 3){ //pertahun
                $start = $params['ReportLosSearch']['start_periode2'];
                $stop = $params['ReportLos']['stop_periode2'];

                $query = $query->andWhere(['between','tgl_billing',$start.'-01-01 00:00:00',$stop.'-12-31 23:59:59']);
            }

        }
        if(!empty($params['ReportLosSearch']['status'])){
            $status = $params['ReportLosSearch']['status'];
            $sqlS = "SELECT td_id from tbl_daftar WHERE td_flag_status ='".$status."'";
            if($status == 2){
                $sqlS = "SELECT td_id from tbl_daftar WHERE td_flag_status in (2,3,4)";
            }
            $dbS = Yii::$app->db->createCommand($sqlS)->queryAll();
            foreach ($dbS as $key => $db) {
                $data[]= $db['td_id'];
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
            'tbs_td_id' => $data,
            'tbs_diagnosa' => $this->tbs_diagnosa,
        ]);

        $query->andFilterWhere(['like', 'tbs_tp_nikes', $this->tbs_tp_nikes])
            ->andFilterWhere(['like', 'tbs_catatan_mitra', $this->tbs_catatan_mitra])
            ->andFilterWhere(['like', 'tbs_path_billing', $this->tbs_path_billing])
            ->andFilterWhere(['like', 'tbs_flag_status', $this->tbs_flag_status])
            ->andFilterWhere(['like', 'tbs_id_user_backend', $this->tbs_id_user_backend])
            ->andFilterWhere(['like', 'tbs_catatan_yakes', $this->tbs_catatan_yakes])
            ->andFilterWhere(['like', 'tbs_id_user_frontend', $this->tbs_id_user_frontend])
            ->andFilterWhere(['like', 'tbs_nama_mitra', $this->tbs_nama_mitra])
            ->andFilterWhere(['like', 'tbs_nama_user_backend', $this->tbs_nama_user_backend])
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
}
