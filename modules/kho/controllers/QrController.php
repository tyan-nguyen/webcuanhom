<?php

namespace app\modules\kho\controllers;

use yii\web\Controller;
use app\modules\maucua\models\KhoNhom;
use app\modules\kho\models\KhoNhomQr;
use yii\web\Response;
use yii\helpers\Html;
use Yii;
use app\modules\maucua\models\DuAn;
use app\modules\maucua\models\NhomSuDung;
use app\modules\maucua\models\MauCua;

/**
 * Default controller for the `kho` module
 */
class QrController extends Controller
{
    public $freeAccessActions = ['view'];
    
    public function behaviors()
    {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }
    /**
     * Render view file
     * Show infomation of thanh  nhôm trong kho
     * input: $code, this is qr_code (text) save in db
     * @return string
     */
    public function actionView($code)
    {
        $this->layout = '/noLayout';
        //check code valid, code check in 2 class: KhoNhom & KhoNhomQr
        $checkCodeValid = false;
        //check in KhoNhom
        $model = KhoNhom::find()->where(['qr_code'=>$code])->one();
        if($model != null){
            $checkCodeValid = true;
        } else {
            $khoNhomQr = KhoNhomQr::find()->where(['qr_code'=>$code])->one();
            if($khoNhomQr != null){
                $checkCodeValid = true;
                $model = $khoNhomQr->khoNhom;
            }
        }
        if($checkCodeValid == true){
            return $this->render('view', compact('model'));
        } else {
            $nhomSuDungQr = NhomSuDung::findOne($code);
            if($nhomSuDungQr != null){
                return $this->render('view_chua_nhap_kho', ['model'=>$nhomSuDungQr]);
            } else {
                return $this->render('view_not_exist', compact($model));
            }
        }
    }
    
    /**
     * In QR cho du an khi xuat kho
     * @return mixed
     */
    public function actionInQrsDuAn($idDuAn)
    {
        $request = Yii::$app->request;
        $duAn = DuAn::findOne($idDuAn);        
        $models = $duAn->dsNhomSuDung;
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $tieuDe = 'Sản xuất theo Kế hoạch';
            return [
                'title'=> "In QR Nhôm dư",
                'content'=>$this->renderAjax('_print_qrs_du_an', compact('models', 'tieuDe')),
                'footer'=> Html::button('Close',['data-bs-dismiss'=>"modal"]). '&nbsp;' .
                Html::button('<i class="fa fa-print"></i> In',['class'=>'btn btn-primary pull-right', 'onClick'=>'printQr()'])
            ];
        }
        
    }
    
    /**
     * In QR cho du an khi xuat kho
     * @return mixed
     */
    public function actionInQrsMauCua($idMauCua)
    {
        $request = Yii::$app->request;
        $mauCua = MauCua::findOne($idMauCua);
        $models = $mauCua->dsNhomSuDung;
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $tieuDe = 'Sản xuất theo mẫu';
            return [
                'title'=> "In QR nhôm dư",
                'content'=>$this->renderAjax('_print_qrs_mau_cua', compact('models', 'tieuDe')),
                'footer'=> Html::button('Close',['data-bs-dismiss'=>"modal"]). '&nbsp;' .
                Html::button('<i class="fa fa-print"></i> In',['class'=>'btn btn-primary pull-right', 'onClick'=>'printQr()'])
            ];
        }
        
    }
    
}
