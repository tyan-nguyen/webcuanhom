<?php

namespace app\modules\kho\models\base;

use Yii;

/**
 * @property int $id
 * @property int $id_kho_vat_tu
 * @property int|null $id_nha_cung_cap
 * @property string|null $ghi_chu
 * @property float|null $so_luong
 * @property float|null $so_luong_cu
 * @property float|null $so_luong_moi
 * @property int|null $id_mau_cua
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaKhoVatTu $khoVatTu
 */
class KhoVatTuLichSuBase extends \app\models\CuaKhoVatTuLichSu
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kho_vat_tu', 'so_luong'], 'required'],
            [['id_kho_vat_tu', 'id_nha_cung_cap', 'id_mau_cua', 'user_created'], 'integer'],
            [['ghi_chu'], 'string'],
            [['so_luong', 'so_luong_cu', 'so_luong_moi'], 'number'],
            [['date_created'], 'safe'],
            [['id_kho_vat_tu'], 'exist', 'skipOnError' => true, 'targetClass' => KhoVatTuBase::class, 'targetAttribute' => ['id_kho_vat_tu' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kho_vat_tu' => 'Kho vật tư',
            'id_nha_cung_cap' => 'Nhà cung cấp',
            'ghi_chu' => 'Ghi chú',
            'so_luong' => 'Số lượng',
            'so_luong_cu' => 'Số lượng cũ',
            'so_luong_moi' => 'Số lượng mới',
            'id_mau_cua' => 'Mẫu cửa',
            'date_created' => 'Ngày tạo',
            'user_created' => 'Tài khoản',
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
