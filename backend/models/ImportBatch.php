<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_import_batch".
 *
 * @property int $tib_id
 * @property string $tib_filename
 * @property string $tib_status 0=queue,1=progress,2=finish
 * @property string $tib_date
 * @property int $tib_total
 * @property int $tib_success
 * @property int $tib_failed
 * @property string $first_user
 */
class ImportBatch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_import_batch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tib_filename'], 'required'],
            [['tib_id', 'tib_total', 'tib_status','tib_success', 'tib_failed'], 'integer'],
            [['tib_date'], 'safe'],
            [['tib_filename',  'first_user'], 'string', 'max' => 255],
            [['tib_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tib_id' => 'ID',
            'tib_filename' => 'File',
            'tib_status' => 'Status',
            'tib_date' => 'Date',
            'tib_total' => 'Total',
            'tib_success' => 'Success',
            'tib_failed' => 'Failed',
            'first_user' => 'Uploader',
        ];
    }
}
