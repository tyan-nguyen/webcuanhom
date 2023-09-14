<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "technologies".
 *
 * @property int $id
 * @property string $name
 * @property string|null $summary
 * @property string|null $date_created
 * @property int|null $user_created
 *
 * @property TemplateTechnologies[] $templateTechnologies
 */
class Technologies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technologies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['summary'], 'string'],
            [['date_created'], 'safe'],
            [['user_created'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'summary' => 'Summary',
            'date_created' => 'Date Created',
            'user_created' => 'User Created',
        ];
    }

    /**
     * Gets query for [[TemplateTechnologies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateTechnologies()
    {
        return $this->hasMany(TemplateTechnologies::class, ['id_technologie' => 'id']);
    }
}
