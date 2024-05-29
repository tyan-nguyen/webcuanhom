<?php

namespace app\modules\dungchung\controllers;

use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\helpers\Html;
use app\modules\dungchung\models\History;

/**
 * Default controller for the `chung` module
 */
class HistoryController extends Controller
{
    public function behaviors()
    {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionViewGroup($loai, $idThamChieu)
    {
        $request = Yii::$app->request;
        
        $history = History::find()->where([
            'loai' => $loai,
            'id_tham_chieu' => $idThamChieu
        ])->all();
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> 'Lịch sử thay đổi',
                'content'=>$this->renderAjax('view-group', [
                    'history' => $history,
                ]),
                'footer'=> Html::button(Yii::t('app', 'Close'),['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
            ];
        }
    }
       
}
