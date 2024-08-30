<?php

namespace app\modules\maucua\controllers;

use Yii;
use app\modules\maucua\models\MauCua;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\maucua\models\MauCuaNhom;
use app\modules\maucua\models\KhoNhom;

/**
 * MauCuaController implements the CRUD actions for MauCua model.
 */
class MauCuaNhomController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
            /* 'verbs' => [
             'class' => VerbFilter::className(),
             'actions' => [
             'delete' => ['POST'],
             ],
             ], */
        ];
    }
    
    /**
     * sua so luong vat tu cua cua
     */
    public function actionSuaNhomPopup($id)
    {
        $request = Yii::$app->request;
        $model = MauCuaNhom::findOne($id);
        $oldModel = MauCuaNhom::findOne($id);
        
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thay đổi cây nhôm",
                    'content'=>$this->renderAjax('_update_cay_nhom', [
                        'model' => $model,
                        'oldModel' => $oldModel
                    ]),
                    'footer'=> Html::button('Save-Popup',['type'=>'submit', 'id'=>'btnSubmitNhom']) . '&nbsp;' .
                    Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
                ];//********************8
            }else if($model->load($request->post())){
                $hasError = false;
                if($model->id_cay_nhom == $oldModel->id_cay_nhom){
                    $hasError = true;
                    $model->addError('id_cay_nhom', 'Vui lòng chọn cây nhôm đích cần chuyển đổi!');
                }
                if($model->xoaCayNhomNguon == true){
                    //check cay nhom da co su dung trong cua khac khong
                    $nhomInCua = MauCuaNhom::find()->where([
                        'id_cay_nhom'=>$oldModel->id_cay_nhom
                    ])->andWhere('id <> ' . $model->id)->one();
                    if($nhomInCua != null){
                        $hasError = true;
                        $model->addError('xoaCayNhomNguon', 'Không thể xóa vì cây nhôm nguồn đã được sử dụng trong mẫu cửa khác! Vui lòng kiểm tra lại');
                    }
                    //check ton kho nhom
                    $tonKhoNhom = KhoNhom::find()->where([
                        'id_cay_nhom' => $oldModel->id_cay_nhom
                    ])->andWhere('so_luong > 0')->one();
                    if($tonKhoNhom != null){
                        $hasError = true;
                        $model->addError('xoaCayNhomNguon', 'Không thể xóa vì cây nhôm nguồn đang có trong tồn kho! Vui lòng kiểm tra lại');
                    }
                }
                if($model->capNhatChoNhomCungMa == true){
                    $cungMaNhomInMauCua = MauCuaNhom::find()->where([
                        'id_mau_cua'=>$model->id_mau_cua,
                        'id_cay_nhom'=>$oldModel->id_cay_nhom,
                    ])->andWhere('id <> ' . $model->id)->one();
                    if($cungMaNhomInMauCua == null){
                        $hasError = true;
                        $model->addError('capNhatChoNhomCungMa', 'Không tìm thấy dữ liệu cùng cây nhôm trong mẫu cửa này!');
                    }
                }
                
                if($hasError == true){
                    return [
                        'title'=> "Thay đổi cây nhôm",
                        'content'=>$this->renderAjax('_update_cay_nhom', [
                            'model' => $model,
                            'oldModel' => $oldModel
                        ]),
                        'footer'=> Html::button('Save-Popup',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close-Popup',['data-bs-dismiss'=>"modal"])
                    ];
                } 
                                
                $model->save();
                
                if($model->capNhatChoNhomCungMa){
                    $cungMaNhomInMauCua = MauCuaNhom::find()->where([
                        'id_mau_cua'=>$model->id_mau_cua,
                        'id_cay_nhom'=>$oldModel->id_cay_nhom,
                    ])->andWhere('id <> ' . $model->id)->all();
                    foreach ($cungMaNhomInMauCua as $nhomInMauCua){
                        $nhomInMauCua->id_cay_nhom = $model->id_cay_nhom;
                        $nhomInMauCua->save();
                    }
                }
                
                if($model->xoaCayNhomNguon){
                    $oldModel->cayNhom->delete();
                }
                
                return [
                    'forceClose'=>true,
                    'runFunc4'=>true,
                    'runFunc4Val1'=>$model->id,
                    'runFunc4Val2'=>$this->renderAjax('_view_item_single_ajax', ['model'=>$model])
                ];
               
            }else{
                return [
                    'title'=> "Thay đổi cây nhôm",
                    'content'=>$this->renderAjax('_update_cay_nhom', [
                        'model' => $model,
                        'oldModel' => $oldModel
                    ]),
                    'footer'=> Html::button('Save-Popup',['type'=>"submit"]) . '&nbsp;' .
                    Html::button('Close-Popup',['data-bs-dismiss'=>"modal"])
                ];
            }
        }
        
    }
    
    /**
     * Delete an existing MauCua model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $type = $model->la_phu_kien == 1 ? 'phukien' : 'vattu';
        $result = $model->la_phu_kien == 1 ? $model->mauCua->dsPhuKien : $model->mauCua->dsVatTu;
        $this->findModel($id)->delete();
        
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'forceClose'=>true,
                'runFunc3'=>true,
                'runFunc3Val1'=>$type,
                'runFunc3Val2'=>$result
            ];
        }else{
            /*
             *   Process for non-ajax request
             */
            return $this->redirect(['index']);
        }
        
        
    }
    
    /**
     * Finds the MauCua model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MauCua the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MauCuaVatTu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
