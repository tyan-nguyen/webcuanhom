<?php

namespace app\modules\maucua\controllers;

use Yii;
use app\modules\maucua\models\LoaiBaoGia;
use app\modules\maucua\models\search\LoaiBaoGiaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\maucua\models\MauCua;
use app\modules\maucua\models\NhomSuDung;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\KhoNhomLichSu;

/**
 * LoaiBaoGiaController implements the CRUD actions for LoaiBaoGia model.
 */
class NhapNhomDuController extends Controller
{
    /**
     * sua cau hinh cua mau cua
     */
    public function actionNhapKho($id)
    {
        $request = Yii::$app->request;
        $model = MauCua::findOne($id);
        if($model == null){
            return [
                'title'=> 'Thông báo',
                'content'=>'Mẫu cửa không tồn tại!',
                'footer'=> Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
            ];
        }
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Nhập kho nhôm dư",
                    'content'=>$this->renderAjax('_form_nhap_kho_nhom', [
                        'model' => $model,
                    ]),
                    'footer'=> ($model->status=="DA_XUAT_KHO" ? (Html::button('Save-Popup',['type'=>'submit']) . '&nbsp;') : '') .
                    Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
                ];
            }else if($model->load($request->post())){
                /* return [
                    'title'=> "Nhập kho nhôm dư",
                    'content'=>var_dump($model->nhomDu),
                    'footer'=> Html::button('Save-Popup',['type'=>'submit']) . '&nbsp;' .
                    Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
                ]; */
                //xu ly nhap kho nhom
                foreach ($model->nhomDu as $idNhomSd=>$cdNhom){
                    if($cdNhom>0){
                        $nhomSd = NhomSuDung::findOne($idNhomSd);                        
                        $tonKhoNhom = KhoNhom::find()->where([
                            'id_cay_nhom'=>$nhomSd->khoNhom->id_cay_nhom,
                            'chieu_dai'=>$cdNhom
                        ])->one();
                       
                        if($tonKhoNhom != null){
                            $slCu = $tonKhoNhom->so_luong;
                            $tonKhoNhom->so_luong += 1;
                            if($tonKhoNhom->save()){
                                $history = new KhoNhomLichSu();
                                $history->id_kho_nhom = $tonKhoNhom->id;
                                $history->so_luong = 1;//1 la thêm 1 cay
                                $history->so_luong_cu = $slCu;
                                $history->so_luong_moi = $tonKhoNhom->so_luong;
                                $history->id_mau_cua = $nhomSd->id_mau_cua;
                                $history->noi_dung = 'Nhập kho nhôm dư từ mẫu cửa #'. $nhomSd->mauCua->code;
                                $history->save();
                            }
                        } else { //them moi
                            $tonKhoNhom = new KhoNhom();
                            $tonKhoNhom->id_cay_nhom = $nhomSd->khoNhom->id_cay_nhom;
                            $tonKhoNhom->chieu_dai = $cdNhom;
                            $tonKhoNhom->so_luong = 1;
                            $tonKhoNhom->noiDung = ': Nhập kho nhôm dư từ mẫu cửa #'. $nhomSd->mauCua->code;
                            $tonKhoNhom->save();
                        }
                    } 
                }
                $model->status = 'DA_NHAP_KHO';
                $model->save(false);
                return [
                    // 'forceReload'=>'#crud-datatable-pjax',
                    'forceClose'=>true,
                    /* 'runFunc2'=>true,
                    'runFunc2Val1'=>$this->renderAjax('_viewSetting', [
                        'setting'=>$model->mauCua->setting
                    ]), */
                    //'runFuncVal2'=>$model->so_luong
                ];
            }else{
                return [
                    'title'=> "Nhập kho nhôm dư",
                    'content'=>$this->renderAjax('_form_nhap_kho_nhom', [
                        'model' => $model,
                    ]),
                    'footer'=> ($model->status=="DA_XUAT_KHO" ? (Html::button('Save-Popup',['type'=>'submit']) . '&nbsp;') : '') .
                    Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
                ];
            }
        }//if isAjax
        
    }
}