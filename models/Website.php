<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "website".
 *
 * @property int $id
 * @property int $id_template
 * @property int|null $user_created
 * @property int|null $date_created
 *
 * @property Template $template
 * @property WebsiteBlocks[] $websiteBlocks
 * @property WebsitePages[] $websitePages
 * @property WebsiteVaribles[] $websiteVaribles
 */
class Website extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'website';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_template'], 'required'],
            [['id_template', 'user_created', 'date_created'], 'integer'],
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
     * Gets query for [[WebsiteBlocks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWebsiteBlocks()
    {
        return $this->hasMany(WebsiteBlocks::class, ['id_website' => 'id']);
    }

    /**
     * Gets query for [[WebsitePages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWebsitePages()
    {
        return $this->hasMany(WebsitePages::class, ['id_website' => 'id']);
    }

    /**
     * Gets query for [[WebsiteVaribles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWebsiteVaribles()
    {
        return $this->hasMany(WebsiteVaribles::class, ['id_website' => 'id']);
    }
}
