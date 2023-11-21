<?php

namespace app\modules\maucua\models;

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
            [['id_du_an'], 'exist', 'skipOnError' => true, 'targetClass' => DuAn::class, 'targetAttribute' => ['id_du_an' => 'id']],
            [['id_mau_cua'], 'exist', 'skipOnError' => true, 'targetClass' => MauCua::class, 'targetAttribute' => ['id_mau_cua' => 'id']],
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
    
    /**
     * Gets query for [[DuAn]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDuAn()
    {
        return $this->hasOne(DuAn::class, ['id' => 'id_du_an']);
    }
    
    /**
     * Gets query for [[MauCua]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMauCua()
    {
        return $this->hasOne(MauCua::class, ['id' => 'id_mau_cua']);
    }
}
