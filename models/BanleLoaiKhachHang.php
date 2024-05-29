<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banle_loai_khach_hang".
 *
 * @property int $id
 * @property string $ten_loai_khach_hang
 * @property string|null $ghi_chu
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property BanleKhachHang[] $banleKhachHangs
 */
class BanleLoaiKhachHang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banle_loai_khach_hang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_loai_khach_hang'], 'required'],
            [['ghi_chu'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['ten_loai_khach_hang'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai_khach_hang' => 'Ten Loai Khach Hang',
            'ghi_chu' => 'Ghi Chu',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[BanleKhachHangs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBanleKhachHangs()
    {
        return $this->hasMany(BanleKhachHang::class, ['id_loai_khach_hang' => 'id']);
    }
}
