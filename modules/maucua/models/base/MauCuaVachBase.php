<?php

namespace app\modules\maucua\models\base;

use Yii;
use app\modules\kho\models\HeVach;

/**
 * This is the model class for table "cua_mau_cua_vach".
 *
 * @property int $id
 * @property int $id_mau_cua
 * @property int $id_vach
 * @property float|null $rong
 * @property float|null $cao
 * @property float|null $so_luong
 * @property float|null $dien_tich
 * @property float $don_gia
 * @property string|null $date_created
 * @property int $user_created
 * @property float|null $so_luong_xuat
 * @property string|null $ghi_chu_xuat
 * @property float|null $so_luong_nhap_lai
 * @property string|null $ghi_chu_nhap_lai
 *
 * @property CuaMauCua $mauCua
 * @property CuaHeVach $vach
 */
class MauCuaVachBase extends \app\models\CuaMauCuaVach
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua', 'id_vach'], 'required'],
            [['id_mau_cua', 'id_vach', 'user_created'], 'integer'],
            [['rong', 'cao', 'so_luong', 'dien_tich', 'don_gia', 'so_luong_xuat', 'so_luong_nhap_lai'], 'number'],
            [['date_created'], 'safe'],
            [['ghi_chu_xuat', 'ghi_chu_nhap_lai'], 'string'],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => MauCuaBase::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
            [['id_vach'], 'exist', 'skipOnError' => true, 'targetClass' => HeVach::class, 'targetAttribute' => ['id_vach' => 'id']],
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
            'id_vach' => 'Id Vach',
            'rong' => 'Rong',
            'cao' => 'Cao',
            'so_luong' => 'So Luong',
            'dien_tich' => 'Dien Tich',
            'don_gia' => 'Don Gia',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
            'so_luong_xuat' => 'So Luong Xuat',
            'ghi_chu_xuat' => 'Ghi Chu Xuat',
            'so_luong_nhap_lai' => 'So Luong Nhap Lai',
            'ghi_chu_nhap_lai' => 'Ghi Chu Nhap Lai',
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
