<?php

namespace app\modules\template\models;

use yii\helpers\ArrayHelper;

class Template extends TemplateBase
{
    /**
     * lay danh sach template
     * @return array
     */
    public static function getList(){
        $list = Template::find()->all();
        return ArrayHelper::map($list, 'id', 'name');
    }
}