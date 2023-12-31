<?php

namespace app\modules\maucua\models\base;

use Yii;

/**
 * This is the model class for table "cua_mau_cua_nhom_su_dung_chi_tiet".
 *
 * @property int $id
 * @property int $id_nhom_su_dung
 * @property int $id_nhom_toi_uu
 * @property int|null $date_created
 * @property int|null $user_created
 *
 * @property CuaMauCuaNhomSuDung $nhomSuDung
 * @property CuaToiUu $nhomToiUu
 */
class NhomSuDungChiTietBase extends \app\models\CuaMauCuaNhomSuDungChiTiet
{
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_nhom_su_dung', 'id_nhom_toi_uu'], 'required'],
            [['id_nhom_su_dung', 'id_nhom_toi_uu', 'date_created', 'user_created'], 'integer'],
            [['id_nhom_su_dung'], 'exist', 'skipOnError' => true, 'targetClass' => NhomSuDungBase::class, 'targetAttribute' => ['id_nhom_su_dung' => 'id']],
            [['id_nhom_toi_uu'], 'exist', 'skipOnError' => true, 'targetClass' => ToiUuBase::class, 'targetAttribute' => ['id_nhom_toi_uu' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_nhom_su_dung' => 'Id Nhom Su Dung',
            'id_nhom_toi_uu' => 'Id Nhom Toi Uu',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
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
