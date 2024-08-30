<?php

namespace app\modules\maucua\controllers;

use Yii;
use app\modules\maucua\models\CayNhom;
use app\modules\maucua\models\search\CayNhomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\maucua\models\KhoNhomLichSu;
use app\modules\maucua\models\KhoNhom;

/**
 * CayNhomController implements the CRUD actions for CayNhom model.
 */
class CayNhomController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
		return [
		    'ghost-access'=> [
		        'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
		    ],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

    /**
     * Lists all CayNhom models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new CayNhomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * lấy thông tin cây nhôm để hiển thị thông tin trước khi lưu khi chọn nhôm trong dropdownlist
     * @param int $id
     * @return string[]|NULL[]|string[]
     */
    public function actionGetNhomAjax($id){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $vt = CayNhom::findOne($id);
        if($vt != null){
            return [
                'status'=>'success',
                'html'=>$this->renderAjax('_nhom_info_ajax', ['model'=>$vt])
            ];
        } else {
            return ['status'=>'failed'];
        }
    }


    /**
     * Displays a single CayNhom model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Cây nhôm",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::a('Edit',
                                    ['update','id'=>$id],
                                    ['role'=>'modal-remote']
                        ). '&nbsp;' .
                            Html::a('addTonKho',['add-ton-kho','id'=>$id],['role'=>'modal-remote'])
                            . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    /**
     * them ton kho nhom
     * @param unknown $id
     * @throws NotFoundHttpException
     * @return string[]
     */
    public function actionAddTonKho($id){
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $khoNhom = new KhoNhom();
        $khoNhom->scenario = 'addTonKhoNhom';
        //$history = new KhoNhomLichSu();
        //$history->scenario = 'addTonKhoNhom';
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm tồn kho cây nhôm " . $model->code ,
                    'content'=>$this->renderAjax('form-ton-kho', [
                        'model' => $model,
                        'khoNhom'=>$khoNhom
                        //'history' => $history
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]). '&nbsp;'
                            .Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }else if($khoNhom->load($request->post())){
                $historySaved = false;
                $khoNhom->id_cay_nhom = $model->id;
                if($khoNhom->validate() == true){
                    //check ton kho cay nhom co chua
                    $nhomTonKho = KhoNhom::findOne([
                        'id_cay_nhom' => $model->id,
                        'chieu_dai' => $khoNhom->chieu_dai
                    ]);
                    $nhomTonKhoOld = KhoNhom::findOne([
                        'id_cay_nhom' => $model->id,
                        'chieu_dai' => $khoNhom->chieu_dai
                    ]);
                    
                    //them moi ton kho neu chua co, neu co roi thi tang so luong
                    if($nhomTonKho == null){
                        $nhomTonKho = new KhoNhom();
                        $nhomTonKho->id_cay_nhom = $model->id;
                        $nhomTonKho->chieu_dai = $khoNhom->chieu_dai;
                        $nhomTonKho->so_luong = $khoNhom->so_luong;
                        if($nhomTonKho->save()){
                            $historySaved = true;
                        }
                    } else {
                        $nhomTonKho->so_luong = $nhomTonKho->so_luong + $khoNhom->so_luong;
                        if($nhomTonKho->save()){
                            $historySaved = true;
                            if($nhomTonKho->so_luong != $nhomTonKhoOld->so_luong){
                                $history = new KhoNhomLichSu();
                                $history->id_kho_nhom = $nhomTonKho->id;
                                $history->so_luong = $khoNhom->so_luong;
                                $history->so_luong_cu = $nhomTonKhoOld->so_luong;
                                $history->so_luong_moi = $nhomTonKho->so_luong;
                                $history->noi_dung = 'Cập nhật tồn kho do thêm mới dữ liệu kho nhôm <br/>'.$khoNhom->noiDung;
                                $history->save();
                            }
                            
                            /* $history->id_kho_nhom = $nhomTonKho->id;
                            if($history->save()){
                                $historySaved = true;
                            } else {
                                $nhomTonKho->so_luong = $nhomTonKho->so_luong - $history->so_luong;
                                $nhomTonKho->save();
                            } */
                        }
                    }
                }
                
                if($historySaved){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "CayNhom #".$id,
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::a('Edit',
                                    ['update','id'=>$id],
                                    ['role'=>'modal-remote']
                                    ). '&nbsp;' .
                                Html::a('addTonKho',['add-ton-kho','id'=>$id],['role'=>'modal-remote'])
                                . '&nbsp;' .
                                Html::button('Close',['data-bs-dismiss'=>"modal"])
                    ];
                } else {
                    return [
                        'title'=> "Thêm tồn kho cây nhôm " . $model->code ,
                        'content'=>$this->renderAjax('form-ton-kho', [
                            'model' => $model,
                            'khoNhom'=>$khoNhom
                            //'history' => $history
                        ]),
                        'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;'
                        .Html::button('Close',['data-bs-dismiss'=>"modal"])
                    ];
                }
            }else{
                return [
                    'title'=> "Thêm tồn kho cây nhôm " . $model->code ,
                    'content'=>$this->renderAjax('form-ton-kho', [
                        'model' => $model,
                        'khoNhom'=>$khoNhom
                        //'history' => $history
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' 
                    .Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * add cây nhôm khác màu cùng mã nhôm
     * id: id cây nhôm
     */
    public function actionAddColor($id){
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(!$model->id_he_mau){
            return [
                'title'=> "Thêm cây nhôm cùng mã " . $model->code ,
                'content'=>'<div class="alert alert-warning" role="alert">
                            Cây nhôm chưa cấu hình màu, Vui lòng chọn màu trước khi thực hiện thao tác</div>' .
                    Html::a('Chọn màu cho cây nhôm',['update', 'id'=>$model->id],[
                        'role'=>'modal-remote',
                        'class'=>'btn btn-sm btn-primary'
                    ]),
                'footer'=> Html::button('Save',['type'=>"submit"]). '&nbsp;'
                .Html::button('Close',['data-bs-dismiss'=>"modal"])
            ];
        }
        if($request->isGet){
            return [
                'title'=> "Thêm cây nhôm cùng mã " . $model->code ,
                'content'=>$this->renderAjax('form-add-color', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Save',['type'=>"submit"]). '&nbsp;'
                .Html::button('Close',['data-bs-dismiss'=>"modal"])
            ];
        }else if($model->load($request->post())){
            if($model->copyMauNhom != null){
                foreach ($model->copyMauNhom as $i=>$val){
                    $cayNhomNew = new CayNhom();
                    $cayNhomNew->attributes = $model->attributes;
                    $cayNhomNew->id_he_mau = $i;
                    $cayNhomNew->id = null;
                    $cayNhomNew->so_luong = 0;
                    $cayNhomNew->save();
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Cây nhôm",
                    'content'=>'<div class="alert alert-success" role="alert">
                          Đã thêm thành công '. count($model->copyMauNhom) .' mã màu cho cây nhôm '.$model->code.'
                        </div>',
                    'footer'=> Html::a('Edit',['update','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            } else {
                $model->addError('copyMauNhom', 'Vui lòng chọn mã màu để thêm!');
                return [
                    'title'=> "Thêm cây nhôm cùng mã " . $model->code ,
                    'content'=>$this->renderAjax('form-add-color', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]). '&nbsp;'
                    .Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }
        } else {
            return [
                'title'=> "Thêm cây nhôm cùng mã " . $model->code ,
                'content'=>$this->renderAjax('form-add-color', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Save',['type'=>"submit"]). '&nbsp;'
                .Html::button('Close',['data-bs-dismiss'=>"modal"])
            ];
        }
    }

    /**
     * Creates a new CayNhom model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new CayNhom();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm cây nhôm",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>'submit']) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>'modal'])
        
                ];         
            }else if($model->load($request->post())){
                //check nhôm trùng
                $checkNhomExist = false;
                if($model->code == null){
                    $nhomExist = CayNhom::find()->where([
                        'id_he_nhom'=>$model->id_he_nhom,
                        'ten_cay_nhom'=>$model->ten_cay_nhom,
                        'do_day'=>$model->do_day,
                    ])->one();
                } else {
                    $nhomExist = CayNhom::find()->where([
                        'id_he_nhom'=>$model->id_he_nhom,
                        'code'=>$model->code,
                        'ten_cay_nhom'=>$model->ten_cay_nhom,
                        'do_day'=>$model->do_day,
                    ])->one();
                }
                if($nhomExist != null){
                    $checkNhomExist = true;
                }
                if($checkNhomExist){
                    $model->addError('ten_cay_nhom', 'Thông tin cây nhôm đã tồn tại, vui lòng kiểm tra lại!');
                    $model->addError('id_he_nhom', 'Thông tin cây nhôm đã tồn tại, vui lòng kiểm tra lại!');
                    $model->addError('do_day', 'Thông tin cây nhôm đã tồn tại, vui lòng kiểm tra lại!');
                    if($model->code != null){
                       $model->addError('code', 'Thông tin cây nhôm đã tồn tại, vui lòng kiểm tra lại!');
                    }
                    return [
                        'title'=> "Thêm mới cây nhôm",
                        'content'=>$this->renderAjax('create', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                        
                    ];  
                }
                if($model->save()){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Thêm mới cây nhôm",
                        'content'=>'<span class="text-success">Thêm mới dữ liệu thành công!</span>',
                        'footer'=> Html::a('Create More',['create'],['role'=>'modal-remote']) . '&nbsp;' .
                                Html::button('Close',['data-bs-dismiss'=>"modal"])
            
                    ];  
                }else{
                    return [
                        'title'=> "Thêm mới cây nhôm",
                        'content'=>$this->renderAjax('create', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                        
                    ];
                }
            }else{           
                return [
                    'title'=> "Thêm mới cây nhôm",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing CayNhom model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $oldModel = $this->findModel($id);
        $chieuDaiCu = $model->chieu_dai;//xu ly ton kho neu chieu dai co thay doi

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật cây nhôm",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];         
            }else if($model->load($request->post()) ){
                //check update trung mau
                if($model->id_he_mau != $oldModel->id_he_mau){
                    $checkPK = CayNhom::find()->where([
                        'code'=>$model->code,
                        'id_he_nhom'=>$model->id_he_nhom
                    ])->andWhere('cast(do_day as decimal(5,2)) ='.$model->do_day);
                    if($model->id_he_mau == NULL){
                        $checkPK = $checkPK->andWhere('id_he_mau IS NULL');
                    } else {
                        $checkPK = $checkPK->andWhere(['id_he_mau'=>$model->id_he_mau]);
                    }
                    if($checkPK->one() != NULL){
                        $model->addError('id_he_mau', 'Đã tồn tại cây nhôm cùng mã, cùng hệ có màu bạn chọn, vui lòng kiểm tra lại!');
                        return [
                            'title'=> "Cập nhật cây nhôm",
                            'content'=>$this->renderAjax('update', [
                                'model' => $model,
                            ]),
                            'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                        ];  
                    }
                }
                
                if($model->save()){
                    /**
                     * kiem tra xem chieu dai co thay doi thi thay doi luon ton kho nhom cua cay nhom moi
                     * -neu chieu dai khong thay doi thi thoi
                     * -neu chieu dai co thay doi thi cap nhat chieu dai ben ton kho nhom tuong ung lai cho
                     * cay nhom moi
                     */
                    if($model->chieu_dai != $chieuDaiCu){
                        $khoNhom = KhoNhom::find()->where([
                            'chieu_dai'=>$chieuDaiCu,
                            'id_cay_nhom'=>$model->id,
                        ])->one();
                        if($khoNhom == null){
                            $khoNhom = new KhoNhom();
                            $khoNhom->id_cay_nhom = $model->id;
                            $khoNhom->chieu_dai = $model->chieu_dai;
                            $khoNhom->so_luong = $model->so_luong!=null?$model->so_luong:0;
                            $khoNhom->save(false);
                        }
                        $khoNhom->chieu_dai = $model->chieu_dai;
                        $khoNhom->save(false);
                    }
                    
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Cây nhôm",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::a('Edit',['update','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                                Html::button('Close',['data-bs-dismiss'=>"modal"])
                    ]; 
                }
            }else{
                 return [
                    'title'=> "Cập nhật cây nhôm",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                     'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing CayNhom model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing CayNhom model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the CayNhom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CayNhom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CayNhom::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
