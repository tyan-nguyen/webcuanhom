<?php

namespace app\modules\template\models;

use Yii;
use app\modules\website\models\WebsiteVaribles;

/**
 * This is the model class for table "template_varibles".
 *
 * @property int $id
 * @property int $id_template
 * @property string $code
 * @property string $name
 * @property string $varible_type
 * @property string $value
 * @property int|null $user_created
 * @property string|null $date_created
 *
 * @property Template $template
 * @property WebsiteVaribles[] $websiteVaribles
 */
class TemplateVariblesBase extends \app\models\TemplateVaribles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_template', 'name', 'value'], 'required'],
            [['id_template', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['code', 'name', 'value'], 'string', 'max' => 255],
            [['varible_type'], 'string', 'max' => 20],
            [['id_template'], 'exist', 'skipOnError' => true, 'targetClass' => Template::class, 'targetAttribute' => ['id_template' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_template' => 'Id Template',
            'code' => 'Code',
            'name' => 'Name',
            'varible_type' => 'Varible Type',
            'value' => 'Value',
            'user_created' => 'User Created',
            'date_created' => 'Date Created',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->datetime_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->isGuest ? '' : Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    public function afterSave( $insert, $changedAttributes ){
        if($this->code == null){
            $this->code = md5($this->id . $this->datetime_created);
            $this->save();
        }
        parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * {@inheritdoc}
     * xoa varible website
     */
    public function beforeDelete()
    {
        //delete website varible
        foreach ($this->websiteVaribles as $varible){
            $varible->delete();
        }
        
        return parent::beforeDelete();
    }

    /**
     * Gets query for [[Template]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::class, ['id' => 'id_template']);
    }

    /**
     * Gets query for [[WebsiteVaribles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWebsiteVaribles()
    {
        return $this->hasMany(WebsiteVaribles::class, ['id_template_varible' => 'id']);
    }
}
