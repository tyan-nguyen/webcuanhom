<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "website_blocks".
 *
 * @property int $id
 * @property int $id_website
 * @property int $id_template_block
 * @property string|null $content
 *
 * @property TemplateBlocks $templateBlock
 * @property Website $website
 */
class WebsiteBlocks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'website_blocks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_website', 'id_template_block'], 'required'],
            [['id_website', 'id_template_block'], 'integer'],
            [['content'], 'string'],
            [['id_template_block'], 'exist', 'skipOnError' => true, 'targetClass' => TemplateBlocks::class, 'targetAttribute' => ['id_template_block' => 'id']],
            [['id_website'], 'exist', 'skipOnError' => true, 'targetClass' => Website::class, 'targetAttribute' => ['id_website' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_website' => 'Id Website',
            'id_template_block' => 'Id Template Block',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[TemplateBlock]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateBlock()
    {
        return $this->hasOne(TemplateBlocks::class, ['id' => 'id_template_block']);
    }

    /**
     * Gets query for [[Website]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWebsite()
    {
        return $this->hasOne(Website::class, ['id' => 'id_website']);
    }
}
