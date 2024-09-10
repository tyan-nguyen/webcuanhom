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
use app\modules\users\models\TaiKhoanInfo;

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
    
    public function actionTest7(){
        /* $arr = TaiKhoanInfo::getListEmailNhanThongBao();
        if($arr!=null){
            $html = '<b>Kết quả kiểm tra mẫu cửa không đạt</b>'; 
            Yii::$app->mailer->compose() // Sử dụng nếu có template
            ->setFrom('notification@vnweb.online') // Mail sẽ gửi đi
            ->setTo($arr) // Mail sẽ nhận
            ->setSubject('[PM Cửa nhôm] Kết quả kiểm tra không đạt') // tiêu đề mail
            ->setHtmlBody($html) // Nội dung mail dạng Html nếu không muốn dùng html thì có thể thay thế bằng setTextBody('Nội dung gửi mail trong Yii2') để chỉ hiển thị text
            ->send();
        } */
    }
    
    public function actionSendEmail(){
        Yii::$app->mailer->compose() // Sử dụng nếu có template
        ->setFrom('notification@vnweb.online') // Mail sẽ gửi đi
        ->setTo('travinhfashion@gmail.com') // Mail sẽ nhận
        ->setSubject('Demo gửi mail trong Yii2') // tiêu đề mail
        ->setHtmlBody('<b>Nội dung gửi mail trong Yii2</b>') // Nội dung mail dạng Html nếu không muốn dùng html thì có thể thay thế bằng setTextBody('Nội dung gửi mail trong Yii2') để chỉ hiển thị text
        ->send();
        
        Yii::$app->mailer->compose() // Sử dụng nếu có template
        ->setFrom('notification@vnweb.online') // Mail sẽ gửi đi
        ->setTo('nguyenvantyan@gmail.com') // Mail sẽ nhận
        ->setSubject('Demo gửi mail trong Yii2') // tiêu đề mail
        ->setHtmlBody('<b>Nội dung gửi mail trong Yii2</b>') // Nội dung mail dạng Html nếu không muốn dùng html thì có thể thay thế bằng setTextBody('Nội dung gửi mail trong Yii2') để chỉ hiển thị text
        ->send();
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
    
    public function actionTest2(){
        return $this->render('test2');
    }
    
    public function actionTest3(){
        return $this->render('test3');
    }
    
    /**
     * tinh nhom su dung theo mang cay Nhom
     */
    public function actionTest4(){
        return $this->render('test4');
    }
    
    /**
     * jusst test
     */
    public function actionTest5(){
        return $this->render('test5');
    }
    
    /**
     * jusst test yii2 conditional
     */
    public function actionTest6(){
        return $this->render('test6');
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
