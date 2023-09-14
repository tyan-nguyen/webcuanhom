<?php

namespace app\modules\template\models;

use Yii;
use app\modules\website\models\Website;

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
class TemplateBase extends \app\models\Template
{
    CONST FOLDER_DOCUMENTS = '/uploads/templates/';
    CONST FOLDER_DOCUMENTS_2 = '\\uploads\templates\\'; //use in render website page
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
    
    public function getTemplateRootFolder(){
        //upload in web
        return Yii::getAlias('@webroot') . TemplateBase::FOLDER_DOCUMENTS . $this->code;
        //upload in base
        //return Yii::getAlias('@webroot') . '/../' . TemplateBase::FOLDER_DOCUMENTS . $this->code;
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->datetime_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->isGuest ? '' : Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    public function afterSave( $insert, $changedAttributes ){
        if($this->code == null){
            $this->code = md5($this->id . $this->datetime_created);
            $this->save();
        }
        if($this->code != null){
            if (!is_dir( $this->getTemplateRootFolder() )) {
                mkdir( $this->getTemplateRootFolder() );
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
    
    public function deleteTemplateFolder($path)
    {
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));
            
            foreach ($files as $file)
            {
                $this->deleteTemplateFolder(realpath($path) . '/' . $file);
            }
            
            return rmdir($path);
        }
        
        else if (is_file($path) === true)
        {
            return unlink($path);
        }
        
        return false;
    }
    
    /**
     * {@inheritdoc}
     * xoa file anh
     */
    public function beforeDelete()
    {
        $this->deleteTemplateFolder($this->getTemplateRootFolder());
        
        foreach ($this->templatePages as $tpage){
            $tpage->delete();
        }
        
        //delete website
        foreach ($this->websites as $web){
            $web->delete();
        }
        //delete varible
        foreach ($this->templateVaribles as $varible){
            $varible->delete();
        }
        //delete block
        foreach ($this->templateBlocks as $block){
            $block->delete();
        }
        
        return parent::beforeDelete();
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
