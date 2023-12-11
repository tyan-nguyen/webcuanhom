<?php

namespace app\modules\maucua\models\base;

use Yii;

/**
 * This is the model class for table "cua_kho_nhom_lich_su".
 *
 * @property int $id
 * @property int $id_kho_nhom
 * @property int $so_luong
 * @property string $noi_dung
 * @property int|null $id_mau_cua
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaKhoNhom $khoNhom
 */
class KhoNhomLichSuBase extends \app\models\CuaKhoNhomLichSu
{
    public $chieuDai;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[/* 'id_kho_nhom',  */'so_luong', 'noi_dung', 'chieuDai'], 'required'],
            [['id_kho_nhom', 'so_luong', 'id_mau_cua', 'user_created'], 'integer'],
            [['chieuDai'], 'number'],
            [['noi_dung'], 'string'],
            [['date_created'], 'safe'],
            [['id_kho_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => KhoNhomBase::class, 'targetAttribute' => ['id_kho_nhom' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kho_nhom' => 'Kho nhôm',
            'so_luong' => 'Số lượng',
            'noi_dung' => 'Nội dung',
            'id_mau_cua' => 'Mẫu cửa',
            'date_created' => 'Ngày tạo',
            'user_created' => 'Tài khoản',
            
            'chieuDai' => 'Chiều dài'
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
