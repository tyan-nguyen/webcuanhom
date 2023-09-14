<?php

namespace app\modules\template\models;

use Yii;

/**
 * This is the model class for table "template_technologies".
 *
 * @property int $id
 * @property int $id_template
 * @property int $id_technologie
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property Technologies $technologie
 * @property Template $template
 */
class TemplateTechnologiesBase extends \app\models\TemplateTechnologies
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_template', 'id_technologie'], 'required'],
            [['id_template', 'id_technologie', 'user_created'], 'integer'],
            [['date_created'], 'safe'],
            [['id_technologie'], 'exist', 'skipOnError' => true, 'targetClass' => Technologies::class, 'targetAttribute' => ['id_technologie' => 'id']],
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
            'id_technologie' => 'Id Technologie',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[Technologie]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTechnologie()
    {
        return $this->hasOne(Technologies::class, ['id' => 'id_technologie']);
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
}
