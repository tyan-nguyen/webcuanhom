<?php

namespace app\modules\maucua\controllers;

use Yii;
use app\modules\maucua\models\MauCua;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\maucua\models\MauCuaVatTu;

/**
 * MauCuaController implements the CRUD actions for MauCua model.
 */
class MauCuaVatTuController extends Controller
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
    public function actionSuaVatTuPopup($id)
    {
        $request = Yii::$app->request;
        $model = MauCuaVatTu::findOne($id);
        
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Chỉnh sửa số lượng",
                    'content'=>$this->renderAjax('_update_so_luong_vat_tu', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save-Popup',['type'=>'submit']) . '&nbsp;' .
                    Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
                ];
            }else if($model->load($request->post())){
                if($model->so_luong < 0){
                    $model->addError('so_luong', 'Bạn không thể nhập số lượng < 0!');
                    return [
                        'title'=> "Chỉnh sửa số lượng",
                        'content'=>$this->renderAjax('_update_so_luong_vat_tu', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Save-Popup',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close-Popup',['data-bs-dismiss'=>"modal"])
                    ];
                } else {
                    $model->save();
                    return [
                        'forceClose'=>true,
                        'runFunc'=>true,
                        'runFuncVal1'=>$model->id,
                        'runFuncVal2'=>$model->so_luong
                    ];
                }
            }else{
                return [
                    'title'=> "Chỉnh sửa số lượng",
                    'content'=>$this->renderAjax('_update_so_luong_vat_tu', [
                        'model' => $model,
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
