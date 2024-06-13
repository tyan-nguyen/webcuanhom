<?php

namespace app\modules\maucua\models;

use Yii;
use app\models\CuaDuAnSettings;

class DuAnSettings extends CuaDuAnSettings
{ 
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_du_an' => 'Dự án',
            'vet_cat' => 'Vết cắt',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_du_an'], 'integer'],
            [['vet_cat'], 'number'],
        ];
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
}