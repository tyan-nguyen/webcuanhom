<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\modules\kho\models\KhoVatTu;

/**
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_kho_vat_tu
 * @property float $so_luong
 * @property string|null $dvt
 * @property float|null $don_gia
 * @property int|null $la_phu_kien
 * @property float|null $so_luong_xuat
 * @property string|null $ghi_chu_xuat
 * @property float|null $so_luong_nhap_lai
 * @property string|null $ghi_chu_nhap_lai
 * @property string|null $date_created
 * @property int|null $user_created
 */
class MauCuaVatTuBase extends \app\models\CuaMauCuaVatTu
{
    public $sluong; //dung de sum so luong khi tong hop vat tu
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_kho_vat_tu', 'so_luong'], 'required'],
            [['id_mau_cua', 'id_kho_vat_tu', 'la_phu_kien', 'user_created'], 'integer'],
            [['so_luong', 'don_gia', 'so_luong_xuat', 'so_luong_nhap_lai'], 'number'],
            [['ghi_chu_xuat', 'ghi_chu_nhap_lai'], 'string'],
            [['date_created', 'sluong'], 'safe'],
            [['dvt'], 'string', 'max' => 20],
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
            'id_kho_vat_tu' => 'Id Kho Vat Tu',
            'so_luong' => 'So Luong',
            'dvt' => 'Dvt',
            'don_gia' => 'Don Gia',
            'la_phu_kien' => 'La Phu Kien',
            'so_luong_xuat' => 'So Luong Xuat',
            'ghi_chu_xuat' => 'Ghi Chu Xuat',
            'so_luong_nhap_lai' => 'So Luong Nhap Lai',
            'ghi_chu_nhap_lai' => 'Ghi Chu Nhap Lai',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }
    
   
}
