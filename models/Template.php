<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "template".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $summary
 * @property int|null $user_created
 * @property string|null $datetime_created
 *
 * @property TemplateBlocks[] $templateBlocks
 * @property TemplatePages[] $templatePages
 * @property TemplateTechnologies[] $templateTechnologies
 * @property TemplateVaribles[] $templateVaribles
 * @property Website[] $websites
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['summary'], 'string'],
            [['user_created'], 'integer'],
            [['datetime_created'], 'safe'],
            [['code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'summary' => 'Summary',
            'user_created' => 'User Created',
            'datetime_created' => 'Datetime Created',
        ];
    }

    /**
     * Gets query for [[TemplateBlocks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateBlocks()
    {
        return $this->hasMany(TemplateBlocks::class, ['id_template' => 'id']);
    }

    /**
     * Gets query for [[TemplatePages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplatePages()
    {
        return $this->hasMany(TemplatePages::class, ['id_template' => 'id']);
    }

    /**
     * Gets query for [[TemplateTechnologies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateTechnologies()
    {
        return $this->hasMany(TemplateTechnologies::class, ['id_template' => 'id']);
    }

    /**
     * Gets query for [[TemplateVaribles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateVaribles()
    {
        return $this->hasMany(TemplateVaribles::class, ['id_template' => 'id']);
    }

    /**
     * Gets query for [[Websites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWebsites()
    {
        return $this->hasMany(Website::class, ['id_template' => 'id']);
    }
}
