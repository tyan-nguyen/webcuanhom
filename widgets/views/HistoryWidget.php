<?php
namespace app\widgets\views;

use yii\base\Widget;
use app\custom\CustomFunc;

class HistoryWidget extends Widget{
    public $data;
    
    public function init(){
        parent::init();
    }
    
    public function run(){
        $custom = new CustomFunc();
        $maHtml = '<div data-bs-spy="scroll" data-bs-target="#navbar-example3" class="scrollspy-example-2" style="height:400px" data-bs-offset="0" tabindex="0">
        <div class="table-responsive border-top-0">
	       <table class="table  text-nowrap border-0 border-top-0 mb-0 ">
		      <tbody>';
		      
	     foreach ($this->data as $key=>$val){
            $maHtml=$maHtml.'<tr>
                    <td><strong>'. $custom->getTenTaiKhoan($val->nguoi_tao) .'</strong> <br/><i>vào lúc</i> <strong><i>'. $custom->convertYMDHISToDMYHIS($val->thoi_gian_tao) .'</i></strong></td>
                    <td>'. $val->noi_dung .'</td>
                    </tr>';
         }
         
       $maHtml=$maHtml.'</tbody>
        	</table>
        </div></div>';
       return $maHtml;
    }
}
?>