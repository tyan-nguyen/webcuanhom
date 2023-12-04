<?php

namespace app\modules\kho\models\base;

use Yii;

/**
 * @property int $id
 * @property int $id_kho_vat_tu
 * @property int|null $id_nha_cung_cap
 * @property string|null $ghi_chu
 * @property float|null $so_luong
 * @property int|null $id_mau_cua
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaKhoVatTu $khoVatTu
 */
class KhoVatTuLichSuBase extends \app\models\CuaKhoNhomLichSu
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kho_vat_tu'], 'required'],
            [['id_kho_vat_tu', 'id_nha_cung_cap', 'id_mau_cua', 'user_created'], 'integer'],
            [['ghi_chu'], 'string'],
            [['so_luong'], 'number'],
            [['date_created'], 'safe'],
            [['id_kho_vat_tu'], 'exist', 'skipOnError' => true, 'targetClass' => KhoVatTu::class, 'targetAttribute' => ['id_kho_vat_tu' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kho_vat_tu' => 'Id Kho Vat Tu',
            'id_nha_cung_cap' => 'Id Nha Cung Cap',
            'ghi_chu' => 'Ghi Chu',
            'so_luong' => 'So Luong',
            'id_mau_cua' => 'Id Mau Cua',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[KhoVatTu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoVatTu()
    {
        return $this->hasOne(KhoVatTu::class, ['id' => 'id_kho_vat_tu']);
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
