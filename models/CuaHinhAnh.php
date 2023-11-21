<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cua_hinh_anh".
 *
 * @property int $id
 * @property string $loai
 * @property int $id_tham_chieu
 * @property string|null $ten_hien_thi
 * @property string|null $duong_dan
 * @property string|null $ten_file_luu
 * @property string|null $img_extension
 * @property float|null $img_size
 * @property string|null $img_wh
 * @property string|null $ghi_chu
 * @property string|null $thoi_gian_tao
 * @property int|null $nguoi_tao
 */
class CuaHinhAnh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cua_hinh_anh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loai', 'id_tham_chieu'], 'required'],
            [['id_tham_chieu', 'nguoi_tao'], 'integer'],
            [['img_size'], 'number'],
            [['ghi_chu'], 'string'],
            [['thoi_gian_tao'], 'safe'],
            [['loai', 'img_wh'], 'string', 'max' => 20],
            [['ten_hien_thi', 'duong_dan', 'ten_file_luu'], 'string', 'max' => 255],
            [['img_extension'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loai' => 'Loai',
            'id_tham_chieu' => 'Id Tham Chieu',
            'ten_hien_thi' => 'Ten Hien Thi',
            'duong_dan' => 'Duong Dan',
            'ten_file_luu' => 'Ten File Luu',
            'img_extension' => 'Img Extension',
            'img_size' => 'Img Size',
            'img_wh' => 'Img Wh',
            'ghi_chu' => 'Ghi Chu',
            'thoi_gian_tao' => 'Thoi Gian Tao',
            'nguoi_tao' => 'Nguoi Tao',
        ];
    }
}
