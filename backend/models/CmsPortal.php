<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cms_portal".
 *
 * @property string $banner1
 * @property string $banner2
 * @property string $banner3
 * @property string $banner4
 * @property string $banner5
 * @property string $fitur1
 * @property string $fitur2
 * @property string $fitur3
 * @property resource $deskripsi
 * @property string $deskripsi_img1
 * @property string $deskripsi_img2
 * @property string $deskripsi_img3
 * @property string $deskripsi_text1
 * @property string $deskripsi_text2
 * @property string $deskripsi_text3
 * @property string $partner_img
 * @property string $partner_text
 * @property string $last_update
 * @property string $last_user
 */
class CmsPortal extends \yii\db\ActiveRecord
{
    public $Element;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_portal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deskripsi'], 'string'],
            // [['last_update', 'last_user'], 'safe'],
            // [['banner1', 'banner2', 'banner3', 'banner4', 'banner5', 'fitur1', 'fitur2', 'fitur3', 'deskripsi_img1', 'deskripsi_img2', 'deskripsi_img3', 'deskripsi_text1', 'deskripsi_text2', 'deskripsi_text3', 'partner_img', 'partner_text','term_con','policy'], 'string', 'max' => 255],
            [['banner1', 'banner2', 'banner3', 'banner4', 'banner5', 'fitur1', 'fitur2', 'fitur3', 'deskripsi_img1', 'deskripsi_img2', 'deskripsi_img3', 'deskripsi_text1', 'deskripsi_text2', 'deskripsi_text3', 'partner_img', 'partner_text','term_con','policy','last_update', 'last_user'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'banner1' => 'Banner1',
            'banner2' => 'Banner2',
            'banner3' => 'Banner3',
            'banner4' => 'Banner4',
            'banner5' => 'Banner5',
            'fitur1' => 'Fitur1',
            'fitur2' => 'Fitur2',
            'fitur3' => 'Fitur3',
            'deskripsi' => 'Deskripsi',
            'deskripsi_img1' => 'Deskripsi Img1',
            'deskripsi_img2' => 'Deskripsi Img2',
            'deskripsi_img3' => 'Deskripsi Img3',
            'deskripsi_text1' => 'Deskripsi Text1',
            'deskripsi_text2' => 'Deskripsi Text2',
            'deskripsi_text3' => 'Deskripsi Text3',
            'partner_img' => 'Partner Img',
            'partner_text' => 'Partner Text',
            'term_con'=> 'Term & Conditions',
            'policy'=> 'Privacy Policy',
            'last_update' => 'Last Update',
            'last_user' => 'Last User',
        ];
    }
}
