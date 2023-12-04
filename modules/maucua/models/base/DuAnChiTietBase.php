<?php

namespace app\modules\maucua\models\base;

use Yii;

/**
 * @property int $id
 * @property int $id_du_an
 * @property int $id_mau_cua
 * @property int $so_luong
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property CuaDuAn $duAn
 * @property CuaMauCua $mauCua
 */
class DuAnChiTietBase extends \app\models\CuaDuAnChiTiet
{    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_du_an', 'id_mau_cua', 'so_luong'], 'required'],
            [['id_du_an', 'id_mau_cua', 'so_luong', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['id_du_an'], 'exist', 'skipOnError' => true, 'targetClass' => DuAnBase::class, 'targetAttribute' => ['id_du_an' => 'id']],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => MauCuaBase::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_du_an' => 'Id Du An',
            'id_mau_cua' => 'Id Mau Cua',
            'so_luong' => 'So Luong',
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
