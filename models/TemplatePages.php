<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "template_pages".
 *
 * @property int $id
 * @property int $id_template
 * @property string $code
 * @property string $name
 * @property string $file
 * @property int $is_dynamic
 * @property int|null $user_created
 * @property string|null $datetime_created
 *
 * @property Template $template
 * @property WebsitePages[] $websitePages
 */
class TemplatePages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template_pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_template', 'code', 'name', 'file', 'is_dynamic'], 'required'],
            [['id_template', 'is_dynamic', 'user_created'], 'integer'],
            [['datetime_created'], 'safe'],
            [['code', 'name', 'file'], 'string', 'max' => 255],
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
            'file' => 'File',
            'is_dynamic' => 'Is Dynamic',
            'user_created' => 'User Created',
            'datetime_created' => 'Date Created',
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
     * Gets query for [[WebsitePages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWebsitePages()
    {
        return $this->hasMany(WebsitePages::class, ['id_templage_page' => 'id']);
    }
}
