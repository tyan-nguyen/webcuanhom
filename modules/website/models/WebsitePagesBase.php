<?php

namespace app\modules\website\models;

use Yii;
use app\modules\template\models\TemplatePages;

/**
 * This is the model class for table "website_pages".
 *
 * @property int $id
 * @property int $id_website
 * @property int $id_template_page
 *
 * @property TemplatePages $templagePage
 * @property Website $website
 */
class WebsitePagesBase extends \app\models\WebsitePages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_website', 'id_template_page'], 'required'],
            [['id_website', 'id_template_page'], 'integer'],
            [['id_template_page'], 'exist', 'skipOnError' => true, 'targetClass' => TemplatePages::class, 'targetAttribute' => ['id_template_page' => 'id']],
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
            'id_template_page' => 'Id Templage Page',
        ];
    }

    /**
     * Gets query for [[TemplagePage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplagePage()
    {
        return $this->hasOne(TemplatePages::class, ['id' => 'id_template_page']);
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
