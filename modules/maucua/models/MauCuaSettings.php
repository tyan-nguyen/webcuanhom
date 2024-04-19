<?php

namespace app\modules\maucua\models;

use app\modules\maucua\models\base\CayNhomBase;
use Yii;
use app\models\CuaMauCuaSettings;

class MauCuaSettings extends CuaMauCuaSettings
{ 
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_mau_cua' => 'Mẫu cửa',
            'vet_cat' => 'Vết cắt',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mau_cua'], 'integer'],
            [['vet_cat'], 'number'],
        ];
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