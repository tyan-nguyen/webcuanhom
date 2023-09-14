<?php

namespace app\modules\website\models;

use Yii;
use app\modules\template\models\TemplateVaribles;

/**
 * This is the model class for table "website_varibles".
 *
 * @property int $id
 * @property int $id_website
 * @property int $id_template_varible
 * @property string|null $value
 *
 * @property TemplateVaribles $templateVarible
 * @property Website $website
 */
class WebsiteVariblesBase extends \app\models\WebsiteVaribles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_website', 'id_template_varible'], 'required'],
            [['id_website', 'id_template_varible'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['id_website'], 'exist', 'skipOnError' => true, 'targetClass' => Website::class, 'targetAttribute' => ['id_website' => 'id']],
            [['id_template_varible'], 'exist', 'skipOnError' => true, 'targetClass' => TemplateVaribles::class, 'targetAttribute' => ['id_template_varible' => 'id']],
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
            'id_template_varible' => 'Id Template Varible',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[TemplageVarible]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateVarible()
    {
        return $this->hasOne(TemplateVaribles::class, ['id' => 'id_template_varible']);
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
