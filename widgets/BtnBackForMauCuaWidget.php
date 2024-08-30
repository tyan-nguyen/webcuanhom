<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;

class BtnBackForMauCuaWidget extends Widget{
    public $model;
    public $type='view';//type in [view, update]
    
    public function init(){
        parent::init();
    }
    
    public function run(){
       $maHtml = '';
       $linkList = [];
       if($this->model != null){               
           if($this->model->id_cong_trinh != null){
               $linkList[] = [
                   'icon'=>'<i class="fa-solid fa-arrow-left"></i>',
                   'text'=>'Về công trình/dự án',
                   'url' => Yii::getAlias('@web/maucua/cong-trinh/view?id='.$this->model->id_cong_trinh)
               ];              
           }
           if($this->model->id_du_an != null){
               $linkList[] = [
                   'icon'=>'<i class="fa-solid fa-arrow-left"></i>',
                   'text'=>'Về Kế hoạch sản xuất',
                   'url' => Yii::getAlias('@web/maucua/du-an/view?id='.$this->model->id_du_an)
               ];
           }
           if($this->type == 'update'){
               $linkList[] = [
                   'icon'=>'<i class="fa-solid fa-arrow-left"></i>',
                   'text'=>'Về Thông tin Mẫu cửa',
                   'url' => Yii::getAlias('@web/maucua/mau-cua/view?id='.$this->model->id)
               ];
           }
           
           $maHtml .= BtnBackWidget::widget([
               'linkList'=>$linkList
           ]); 
       } else {
           $maHtml .= 'Chưa cấu hình model';
       }
       return $maHtml;
    }
}
?>