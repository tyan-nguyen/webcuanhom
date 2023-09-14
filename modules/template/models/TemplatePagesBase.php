<?php

namespace app\modules\template\models;

use Yii;
use app\modules\website\models\WebsitePages;

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
class TemplatePagesBase extends \app\models\TemplatePages
{
    public $fileInput;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_template', 'name', 'file'], 'required'],
            [['id_template', 'is_dynamic', 'user_created'], 'integer'],
            [['datetime_created'], 'safe'],
            [['code', 'name', 'file'], 'string', 'max' => 255],
            [['id_template'], 'exist', 'skipOnError' => true, 'targetClass' => Template::class, 'targetAttribute' => ['id_template' => 'id']],
            [['fileInput'], 'string', 'max' => 255],
            [['fileInput'], 'file'],
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
            
            'fileInput' => 'File',
        ];
    }
    
    
    public function getFileRootUrl(){
        return $this->template->getTemplateRootFolder() . '/' . $this->file;
    }
    
    //upload in base
   /*  public function getFileRenderUrl(){
        return '..\..\..\..' . TemplateBase::FOLDER_DOCUMENTS_2 . $this->template->code . '\\' . $this->file;
    } */
    //upload in web
    public function getFileRenderUrl(){
        return '..\..\..\..\web' . TemplateBase::FOLDER_DOCUMENTS_2 . $this->template->code . '\\' . $this->file;
    }
    
    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->datetime_created = date('Y-m-d H:i:s');
            $this->user_created = Yii::$app->user->isGuest ? '' : Yii::$app->user->id;
            if($this->is_dynamic == null)
                $this->is_dynamic = 1;
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
        parent::afterSave($insert, $changedAttributes);
    }
    
    
    /**
     * {@inheritdoc}
     * xoa file anh
     */
    public function beforeDelete()
    {
        if(file_exists($this->getFileRootUrl())){
            unlink($this->getFileRootUrl());
        }
        
        //delete website page
        foreach ($this->websitePages as $page){
            $page->delete();
        }
        
        return parent::beforeDelete();
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
        return $this->hasMany(WebsitePages::class, ['id_template_page' => 'id']);
    }
}
