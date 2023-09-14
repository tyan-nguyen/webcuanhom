<?php

namespace app\modules\website\controllers;

use Yii;
use yii\web\Controller;
use app\modules\website\models\Website;
use app\modules\website\models\WebsitePages;
use app\modules\template\models\TemplatePages;
use app\modules\website\models\WebsiteVaribles;
use app\models\WebsiteBlocks;
use yii\web\Response;
use yii\helpers\Html;

/**
 * Default controller for the `website` module
 */
class WebController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $website = Website::find()->all();
        return $this->render('index', compact('website'));
    }
    
    public function actionCreate(){
        $model = new Website();
        
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }
        
        return $this->render('formWebsite', compact('model'));
    }
    
    public function actionView($id)
    {
        $model = Website::findOne($id);
        return $this->render('view', compact('model'));
    }
    
    public function actionDetail($id)
    {
        $webpage = WebsitePages::findOne($id);
        $page = TemplatePages::findOne($webpage->id_template_page);
        $model = Website::findOne($webpage->id_website);
        $varibles = $model->getVaribles();
        $blocks = $model->getBlocks();
        return $this->render('detail', compact('page', 'varibles', 'blocks'));
    }
    
    public function actionEditVar($id) {
        $request = Yii::$app->request;
        $model = WebsiteVaribles::findOne($id); // your model can be loaded here
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật",
                    'content'=>$this->renderAjax('_formVar', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Save & close',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#pjax',
                    'forceClose'=>true,
                ];
            }
        }       
    }
    
    public function actionEditBlock($id) {
        $request = Yii::$app->request;
        $model = WebsiteBlocks::findOne($id); // your model can be loaded here
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật",
                    'content'=>$this->renderAjax('_formBlock', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-bs-dismiss'=>"modal"]).
                    Html::button('Save & close',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#pjax',
                    'forceClose'=>true,
                ];
            }
        }
    }
    
    public function actionDeleteFile(){
        $src = explode('/uploads', $_POST['src']);
        $src =  '\uploads' . str_replace('/', '\\', $src[1]);
        
        if($src != null){
            if(file_exists(Yii::getAlias('@webroot') . $src )){
                if(unlink(Yii::getAlias('@webroot') . $src ) ){
                    return 'File Delete Successfully';
                }
            }
        }
       // return Yii::getAlias('@webroot') . $src;
    }
    
}