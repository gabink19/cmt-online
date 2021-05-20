<?php

namespace frontend\models;

use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\BillingSementara;

/**
 * BillingSementaraSearch represents the model behind the search form of `frontend\models\BillingSementara`.
 */
class BillingSementaraSearch extends BillingSementara
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tbs_id', 'tbs_td_id', 'flag_deleted'], 'integer'],
            [['tbs_tp_nikes','tbs_biaya', 'tbs_catatan_mitra', 'tbs_path_billing', 'tbs_flag_status', 'tbs_id_user_backend', 'tbs_catatan_yakes', 'tbs_id_user_frontend', 'tbs_nama_mitra', 'tbs_nama_user_backend', 'tgl_billing', 'tgl_billing_diresponse', 'first_ip_backend', 'last_ip_backend', 'first_ip_frontend', 'last_ip_frontend', 'first_date_backend', 'last_date_backend', 'first_date_frontend', 'last_date_frontend', 'first_user_backend', 'last_user_backend', 'first_user_frontend', 'last_user_frontend'], 'safe'],
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
        $query = BillingSementara::find();

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
        if (isset($params['BillingSementaraSearch']['start_periode'])) {

            if ($params['BillingSementaraSearch']['start_periode'] != "" && $params['BillingSementaraSearch']['stop_periode'] != "") {

                $query = $query->andWhere(['between','tgl_billing',$params['BillingSementaraSearch']['start_periode'].' 00:00:00',$params['BillingSementaraSearch']['stop_periode'].' 23:59:59']);
            }
        }else{
            $query = $query->andWhere(['between','tgl_billing',date('Y-m-d').' 00:00:00',date('Y-m-d').' 23:59:59']);
        }

        if (Yii::$app->user->identity->rs_mitra!='' && Yii::$app->user->identity->bidang_mitra != 9) {
            $query->andFilterWhere(['like', 'tbs_nama_mitra', Yii::$app->user->identity->rs_mitra]);
        }else{
            $query->andFilterWhere(['like', 'tbs_nama_mitra', $this->tbs_nama_mitra]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'tbs_id' => $this->tbs_id,
            'tbs_td_id' => $this->tbs_td_id,
            'tgl_billing' => $this->tgl_billing,
            'tgl_billing_diresponse' => $this->tgl_billing_diresponse,
            'first_date_backend' => $this->first_date_backend,
            'last_date_backend' => $this->last_date_backend,
            'first_date_frontend' => $this->first_date_frontend,
            'last_date_frontend' => $this->last_date_frontend,
            'tbs_biaya' => $this->tbs_biaya,
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
