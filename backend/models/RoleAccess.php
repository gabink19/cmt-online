<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "role_access".
 *
 * @property string $usermode
 * @property string $menu
 */
class RoleAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usermode'], 'string', 'max' => 100],
            [['menu_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usermode' => 'Usermode',
            'menu_id' => 'Menu ID',
        ];
    }
}
