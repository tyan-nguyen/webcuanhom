<?php

namespace app\models;

use Yii;

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
class TemplateVaribles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template_varibles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_template', 'code', 'name', 'varible_type', 'value'], 'required'],
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
        return $this->hasMany(WebsiteVaribles::class, ['id_templage_varible' => 'id']);
    }
}
