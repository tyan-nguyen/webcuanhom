<?php

namespace app\modules\website\controllers;

use Yii;
use yii\web\Controller;
use app\modules\website\models\Website;
use app\modules\website\models\WebsitePages;
use app\modules\template\models\TemplatePages;
use app\modules\website\models\WebsiteVaribles;
use app\models\WebsiteBlocks;

/**
 * Default controller for the `website` module
 */
class DefaultController extends Controller
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
        $model = WebsiteVaribles::findOne($id); // your model can be loaded here
        
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            // store old value of the attribute
            $oldValue = $model->value;
            
            // read your posted model attributes
            //if ($model->load($_POST)) {
            
            $model->value = $_POST['varible'];
                // read or convert your posted information
                $value = $model->value;
                
                // validate if any errors
                if ($model->save()) {
                    // return JSON encoded output in the below format on success with an empty `message`
                    return ['output' => $value, 'message' => ''];
                } else {
                    // alternatively you can return a validation error (by entering an error message in `message` key)
                    return ['output' => $oldValue, 'message' => 'Incorrect Value! Please reenter.'];
                }
            //}
            // else if nothing to do always return an empty JSON encoded output
            /* else {
                return ['output'=>'', 'message'=>''];
            } */
        }
        
        // Else return to rendering a normal view
        //return $this->render('view', ['model' => $model]);
    }
    
    public function actionEditBlock($id) {
        $model = WebsiteBlocks::findOne($id); // your model can be loaded here
        
        // Check if there is an Editable ajax request
        if (isset($_POST['hasEditable'])) {
            // use Yii's response format to encode output as JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            // store old value of the attribute
            $oldValue = $model->content;
            
            // read your posted model attributes
            //if ($model->load($_POST)) {
            
            $model->content = $_POST['block'];
            // read or convert your posted information
            $value = $model->content;
            
            // validate if any errors
            if ($model->save()) {
                // return JSON encoded output in the below format on success with an empty `message`
                return ['output' => $value, 'message' => ''];
            } else {
                // alternatively you can return a validation error (by entering an error message in `message` key)
                return ['output' => $oldValue, 'message' => 'Incorrect Value! Please reenter.'];
            }
            //}
            // else if nothing to do always return an empty JSON encoded output
            /* else {
             return ['output'=>'', 'message'=>''];
             } */
        }
        
        // Else return to rendering a normal view
        //return $this->render('view', ['model' => $model]);
    }
    
    public function actionUpload(){
        if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $filename = $name. '.' .$ext;
                $destination = Yii::getAlias('@webroot') . '/uploads/images/'.$filename; //change this directory
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                return Yii::getAlias('@web') . '/uploads/images/'.$filename; //change this URL
            } else {
                return 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
            }
        }
    }
}
