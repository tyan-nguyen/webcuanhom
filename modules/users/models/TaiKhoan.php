<?php
namespace app\modules\users\models;

use webvimark\modules\UserManagement\models\User;
use yii\helpers\ArrayHelper;
use app\models\UserInfo;

class TaiKhoan extends User{
    /** After record is saved
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        $userInfo = new UserInfo();
        $userInfo->id_user = $this->id;
        $userInfo->save(false);
        
    }
    
    public static function getListTaiKhoan(){
        $taiKhoan = TaiKhoan::find()->all();
        return ArrayHelper::map($taiKhoan, 'id', function($model){
           return $model->username; 
        });
    }
}