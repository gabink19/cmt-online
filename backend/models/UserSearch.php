<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form of `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'flag_multiple', 'flag_login', 'bidang_user', 'flag_active', 'bidang_mitra', 'type_user'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'first_user', 'first_ip', 'first_update', 'last_user', 'last_ip', 'last_update', 'active_date', 'usermode', 'last_action', 'ip', 'lastvisit', 'no_telp', 'nama', 'rs_mitra', 'alamat_rs', 'flag_mobile', 'expired_mobile'], 'safe'],
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
        $query = User::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'first_update' => $this->first_update,
            'last_update' => $this->last_update,
            'active_date' => $this->active_date,
            'flag_multiple' => $this->flag_multiple,
            'last_action' => $this->last_action,
            'flag_login' => $this->flag_login,
            'lastvisit' => $this->lastvisit,
            'bidang_user' => $this->bidang_user,
            'flag_active' => $this->flag_active,
            'bidang_mitra' => $this->bidang_mitra,
            'type_user' => $this->type_user,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_user', $this->first_user])
            ->andFilterWhere(['like', 'first_ip', $this->first_ip])
            ->andFilterWhere(['like', 'last_user', $this->last_user])
            ->andFilterWhere(['like', 'last_ip', $this->last_ip])
            ->andFilterWhere(['like', 'usermode', $this->usermode])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'no_telp', $this->no_telp])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'rs_mitra', $this->rs_mitra])
            ->andFilterWhere(['like', 'alamat_rs', $this->alamat_rs]);

        return $dataProvider;
    }
}
