<?php

namespace app\modules\maucua\models;

use Yii;

class HeNhomMau extends \app\models\CuaHeNhomMau
{  
    public $code_he_mau;//use in query
    public $ten_he_mau;//use in query
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_he_nhom', 'id_he_mau'], 'required'],
            [['id_he_nhom', 'id_he_mau', 'is_mac_dinh', 'user_created'], 'integer'],
            [['date_created', 'code_he_mau', 'ten_he_mau'], 'safe'],
            [['id_he_nhom'], 'exist', 'skipOnError' => true, 'targetClass' => HeNhom::class, 'targetAttribute' => ['id_he_nhom' => 'id']],
            [['id_he_mau'], 'exist', 'skipOnError' => true, 'targetClass' => HeMau::class, 'targetAttribute' => ['id_he_mau' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->date_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->id;
            if($this->is_mac_dinh==null){
                $this->is_mac_dinh = 0;
            }
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_he_nhom' => 'Id He Nhom',
            'id_he_mau' => 'Id Mau',
            'is_mac_dinh' => 'Is Mac Dinh',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }
    
    /**
     * Gets query for [[HeNhom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeNhom()
    {
        return $this->hasOne(HeNhom::class, ['id' => 'id_he_nhom']);
    }
    
    /**
     * Gets query for [[Mau]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMau()
    {
        return $this->hasOne(HeMau::class, ['id' => 'id_he_mau']);
    }
}