<?php

namespace app\modules\maucua\models\base;

use Yii;

/**
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_cay_nhom
 * @property float|null $chieu_dai
 * @property int|null $so_luong
 * @property string|null $kieu_cat
 * @property float|null $khoi_luong
 * @property float|null $don_gia
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CayNhom $cayNhom
 * @property MauCua $mauCua
 */
class MauCuaNhomBase extends \app\models\CuaMauCuaNhom
{    
    public $xoaCayNhomNguon; //tuy chon xoa cay nhom goc sau khi doi sang cay nhom khac trong mauCuaNhom
    public $capNhatChoNhomCungMa; // tuy chon de thay doi luon cac cay nhom cung ma trong mauCua
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_cay_nhom'], 'required'],
            [['id_mau_cua', 'id_cay_nhom', 'so_luong', 'user_created'], 'integer'],
            [['chieu_dai', 'khoi_luong', 'don_gia'], 'number'],
            [['date_created', 'xoaCayNhomNguon', 'capNhatChoNhomCungMa'], 'safe'],
            [['kieu_cat'], 'string', 'max' => 11],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => MauCuaBase::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
            [['id_cay_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => CayNhomBase::class, 'targetAttribute' => ['id_cay_nhom' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_mau_cua' => 'Id Mau Cua',
            'id_cay_nhom' => 'Cây nhôm',
            'chieu_dai' => 'Chieu Dai',
            'so_luong' => 'So Luong',
            'kieu_cat' => 'Kieu Cat',
            'khoi_luong' => 'Khoi Luong',
            'don_gia' => 'Don Gia',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
            'xoaCayNhomNguon' => 'Xóa cây nhôm nguồn',
            'capNhatChoNhomCungMa' => 'Cập nhật cho tất cả cây nhôm cùng mã trong mẫu cửa'
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }
    
    
}