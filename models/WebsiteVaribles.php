<?php

namespace app\models;

use Yii;

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
class WebsiteVaribles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'website_varibles';
    }

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
            'id_template_varible' => 'Id template Varible',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[templateVarible]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function gettemplateVarible()
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
