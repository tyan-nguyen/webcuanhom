<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\modules\dungchung\models\Setting;
use yii\helpers\Html;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'ghost-access'=> [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionTest(){
        return $this->render('test');
    }
    
    /**
     * Displays setting page.
     *
     * @return string
     */
    public function actionSetting()
    {
        $request = Yii::$app->request;
        $model = Setting::find()->one();
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Cập nhật Cấu hình",
                'content'=>$this->renderAjax('setting', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Save',['type'=>'submit']) . '&nbsp;' .
                Html::button('Close',['data-bs-dismiss'=>'modal'])
            ];
        }else if($model->load($request->post()) && $model->save()){
            return [
                'title'=> "Cập nhật Cấu hình",
                'content'=>$this->renderAjax('setting', [
                    'model' => $model,
                    'message'=>'Cập nhật thông tin cấu hình thành công!',
                ]),
                'footer'=> Html::button('Save',['type'=>'submit']) . '&nbsp;' .
                Html::button('Close',['data-bs-dismiss'=>'modal'])
            ];
        }else{
            return [
                'title'=> "Cập nhật Cấu hình",
                'content'=>$this->renderAjax('setting', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Save',['type'=>'submit']) . '&nbsp;' .
                Html::button('Close',['data-bs-dismiss'=>'modal'])
            ];
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
