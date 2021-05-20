<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ReportTrackingHistory;
use Yii;

/**
 * ReportTrackingHistorySearch represents the model behind the search form of `backend\models\ReportTrackingHistory`.
 */
class ReportTrackingHistorySearch extends ReportTrackingHistory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tbs_id', 'tbs_td_id', 'flag_deleted'], 'integer'],
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
        $query = ReportTrackingHistory::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if(empty($params['ReportTrackingHistorySearch'])){
            $query = $query->andWhere(['between','tgl_billing',"1970-01-01 00:00:00","1970-01-01 23:59:59"]);            
        }

        if(!empty($params['ReportTrackingHistorySearch']['start_periode']) && !empty($params['ReportTrackingHistorySearch']['stop_periode'])){
            // if($tipe == 1){ //perbulan
                // $sampe = strtotime('30 days');
                $start = $params['ReportTrackingHistorySearch']['start_periode'];
                $stop = $params['ReportTrackingHistorySearch']['stop_periode'];

                $query = $query->andWhere(['between','tgl_billing',$start." 00:00:00",$stop." 23:59:59"]);
            // }
        }
        
        if(($params['ReportTrackingHistorySearch']['mitra']) != ""){
            $mitra = $params['ReportTrackingHistorySearch']['mitra'];
            $sql = "SELECT td_id from tbl_daftar WHERE td_mitra ='".$mitra."'";

            $db = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($db as $keys => $db2) {
                $data[]= $db2['td_id'];
            }
        }
        if(($params['ReportTrackingHistorySearch']['host']) != ""){
            $host = $params['ReportTrackingHistorySearch']['host'];
            $sql = "SELECT tp_id from tbl_peserta where kategori_host='".$host."'";
            $dbRa = Yii::$app->db->createCommand($sql)->queryAll();
            $data2 = "";
            foreach ($dbRa as $keys => $db2) {
                $data2 .= $db2['tp_id'].",";
            }
            $data2 = substr($data2, 0, -1);
            // $data2 .= ")";
            $sql = "SELECT td_id from tbl_daftar WHERE td_tp_id in (".$data2.")";
            $db = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($db as $keys => $db2) {
                $data[] = $db2['td_id'];
            }
        }

        if(($params['ReportTrackingHistorySearch']['tujuan']) != ""){
            $tujuan = $params['ReportTrackingHistorySearch']['tujuan'];
            $sql = "SELECT td_id from tbl_daftar WHERE td_tujuan ='".$tujuan."'";

            $db = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($db as $keys => $db2) {
                $data[]= $db2['td_id'];
            }
        }

        if($params['ReportTrackingHistorySearch']['tujuan'] != "" && $params['ReportTrackingHistorySearch']['host'] != ""){ // tujuan && host
            unset($data);
            $sql = "SELECT td_id from tbl_daftar WHERE td_tp_id in (".$data2.") AND td_tujuan ='".$tujuan."'";

            $db = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($db as $keys => $db2) {
                $data[]= $db2['td_id'];
            }
        }

        if($params['ReportTrackingHistorySearch']['tujuan'] != "" && $params['ReportTrackingHistorySearch']['mitra'] != ""){ // tujuan && mitra
            unset($data);
            $sql = "SELECT td_id from tbl_daftar WHERE td_tujuan ='".$tujuan."' AND td_mitra ='".$mitra."'";

            $db = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($db as $keys => $db2) {
                $data[]= $db2['td_id'];
            }
        }

        if($params['ReportTrackingHistorySearch']['mitra'] != "" && $params['ReportTrackingHistorySearch']['host'] != ""){ // host && mitra
            unset($data);
            $sql = "SELECT td_id from tbl_daftar WHERE td_mitra ='".$mitra."' AND td_tp_id in (".$data2.")";

            $db = Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($db as $keys => $db2) {
                $data[]= $db2['td_id'];
            }
        }

        if($params['ReportTrackingHistorySearch']['tujuan'] != "" && $params['ReportTrackingHistorySearch']['host'] != "" && $params['ReportTrackingHistorySearch']['mitra'] != ""){ // tujuan&&host&&mitra
            unset($data);
            $sql = "SELECT td_id from tbl_daftar WHERE td_tp_id in (".$data2.") AND td_tujuan ='".$tujuan."' AND td_mitra ='".$mitra."'";

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
            'tbs_td_id' => $data,
            'flag_deleted' => 0,
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
}
