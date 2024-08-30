<?php

namespace app\modules\kho\controllers;

use Yii;
use app\modules\kho\models\PhuKien;
use app\modules\kho\models\search\PhuKienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\kho\models\KhoVatTuLichSu;
use app\modules\dungchung\models\Setting;

/**
 * PhuKienController implements the CRUD actions for PhuKien model.
 */
class PhuKienController extends Controller
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
     * Lists all PhuKien models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhuKienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    /**
     * Displays a single PhuKien model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Thông tin phụ kiện",
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
     * add phụ kiện khác màu cùng mã
     * id: id cây nhôm
     */
    public function actionAddColor($id){
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($request->isGet){
            return [
                'title'=> "Thêm phụ kiện cùng mã " . $model->code ,
                'content'=>$this->renderAjax('form-add-color', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Save',['type'=>"submit"]). '&nbsp;'
                .Html::button('Close',['data-bs-dismiss'=>"modal"])
            ];
        }else if($model->load($request->post())){
            if($model->copyMau != null){
                foreach ($model->copyMau as $i=>$val){
                    $phuKienNew = new PhuKien();
                    $phuKienNew->attributes = $model->attributes;
                    $phuKienNew->id_he_mau = $i;
                    $phuKienNew->id = null;
                    $phuKienNew->so_luong = 0;
                    $phuKienNew->save();
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Phụ kiện",
                    'content'=>'<div class="alert alert-success" role="alert">
                          Đã thêm thành công '. count($model->copyMau) .' mã màu cho phụ kiện '.$model->code.'
                        </div>',
                    'footer'=> Html::a('Edit',['update','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            } else {
                $model->addError('copyMau', 'Vui lòng chọn mã màu để thêm!');
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
                'title'=> "Thêm phụ kiện cùng mã " . $model->code ,
                'content'=>$this->renderAjax('form-add-color', [
                    'model' => $model,
                ]),
                'footer'=> Html::button('Save',['type'=>"submit"]). '&nbsp;'
                .Html::button('Close',['data-bs-dismiss'=>"modal"])
            ];
        }
    }
    
    /**
     * them ton kho vat tu
     * sua so luong ton kho va luu vao lich su thay doi ton kho
     * @param unknown $id
     * @throws NotFoundHttpException
     * @return string[]
     */
    public function actionAddTonKho($id){
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $history = new KhoVatTuLichSu();
        $setting = Setting::find()->one();
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm tồn kho " . $model->code ,
                    'content'=>$this->renderAjax('_form-ton-kho', [
                        'model' => $model,
                        'history' => $history
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]). '&nbsp;'
                    .Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }else if($history->load($request->post())){
                $history->id_kho_vat_tu = $model->id;
                $history->so_luong_cu = $model->so_luong;
                $soLuongConLai = $model->so_luong + ($history->so_luong == null ? 0 : $history->so_luong);
                if($history->so_luong < 0 && $soLuongConLai < 0){
                    if($setting->cho_phep_nhap_kho_am != true){
                        $history->addError('so_luong', 'Cấu hình phần mềm không cho phép thêm tồn kho âm. Bạn vui lòng thay đổi cấu hình. Nếu bạn không có quyền thay đổi vui lòng liên hệ người quản trị!');
                        return [
                            'title'=> "Thêm tồn kho" . $model->code ,
                            'content'=>$this->renderAjax('_form-ton-kho', [
                                'model' => $model,
                                'history' => $history
                            ]),
                            'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;'
                            .Html::button('Close',['data-bs-dismiss'=>"modal"])
                        ];
                    }
                }
                $history->so_luong_moi = $soLuongConLai;
                $history->id_mau_cua = null;//***
                if($history->save()){
                    //sửa tồn kho
                    $model->so_luong = $model->so_luong + $history->so_luong;
                    if($model->save()){
                        return [
                            'forceReload'=>'#crud-datatable-pjax',
                            'title'=> "Thông tin phụ kiện",
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
                        $history->delete();
                        return [
                            'title'=> "Thêm tồn kho " . $model->code ,
                            'content'=>'Có lỗi xảy - mã lỗi: #E0001',
                            'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;'
                            .Html::button('Close',['data-bs-dismiss'=>"modal"])
                        ];
                    }
                } else {
                    return [
                        'title'=> "Thêm tồn kho" . $model->code ,
                        'content'=>$this->renderAjax('_form-ton-kho', [
                            'model' => $model,
                            'history' => $history
                        ]),
                        'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;'
                        .Html::button('Close',['data-bs-dismiss'=>"modal"])
                    ];
                }
            }else{
                return [
                    'title'=> "Thêm tồn kho " . $model->code ,
                    'content'=>$this->renderAjax('_form-ton-kho', [
                        'model' => $model,
                        'history' => $history
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
     * add lich su ton kho nhom
     * @param unknown $id
     * @throws NotFoundHttpException
     * @return string[]
     * **************************************** dang xu ly *************************
     */
/*     public function actionAddLichSu($id){
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $history = new KhoVatTuLichSu();
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm tồn kho vật tư " . $model->code ,
                    'content'=>$this->renderAjax('form-ton-kho', [
                        'model' => $model,
                        'history' => $history
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]). '&nbsp;'
                    .Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }else if($history->load($request->post())){
                $historySaved = false;
                
                if($history->validate() == true){
                    //check ton kho cay nhom co chua
                    $nhomTonKho = KhoVatTuLichSu::findOne([
                        'id_cay_nhom' => $model->id,
                        'chieu_dai' => $history->chieuDai
                    ]);
                    
                    //them moi ton kho neu chua co, neu co roi thi tang so luong
                    if($nhomTonKho == null){
                        $nhomTonKho = new KhoNhom();
                        $nhomTonKho->id_cay_nhom = $model->id;
                        $nhomTonKho->chieu_dai = $history->chieuDai;
                        $nhomTonKho->so_luong = $history->so_luong;
                        if($nhomTonKho->save()){
                            $history->id_kho_nhom = $nhomTonKho->id;
                            if($history->save()){
                                $historySaved = true;
                            }else{
                                $nhomTonKho->delete();
                            }
                        }
                    } else {
                        $nhomTonKho->so_luong = $nhomTonKho->so_luong + $history->so_luong;
                        if($nhomTonKho->save()){
                            $history->id_kho_nhom = $nhomTonKho->id;
                            if($history->save()){
                                $historySaved = true;
                            } else {
                                $nhomTonKho->so_luong = $nhomTonKho->so_luong - $history->so_luong;
                                $nhomTonKho->save();
                            }
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
                            'history' => $history
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
                        'history' => $history
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;'
                    .Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    } */
    
    /**
     * Creates a new KhoVatTu model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PhuKien();
        $model->id_nhom_vat_tu = 1;//1 is phu kien
        
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới phụ kiện",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>'submit']) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>'modal'])
                    
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới phụ kiện",
                    'content'=>'<span class="text-success">Thêm mới thông tin thành công!</span>',
                    'footer'=> Html::a('Create More',['create'],['role'=>'modal-remote']) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }else{
                return [
                    'title'=> "Thêm mới phụ kiện",
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
     * Updates an existing PhuKien model.
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
        
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật phụ kiện",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post())){
                //check update trung mau
                if($model->id_he_mau != $oldModel->id_he_mau){
                    $checkPK = PhuKien::find()->where([
                        'code'=>$model->code,
                    ]);
                    if($model->id_he_mau == NULL){
                        $checkPK = $checkPK->andWhere('id_he_mau IS NULL');
                    } else {
                        $checkPK = $checkPK->andWhere(['id_he_mau'=>$model->id_he_mau]);
                    }
                    if($checkPK->one() != NULL){
                        $model->addError('id_he_mau', 'Đã tồn tại phụ kiện cùng mã có màu bạn chọn, vui lòng kiểm tra lại!');
                        return [
                            'title'=> "Cập nhật phụ kiện",
                            'content'=>$this->renderAjax('update', [
                                'model' => $model,
                            ]),
                            'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                        ];
                    }
                }
                if($model->save()){
                    //them lich su ton kho neu thay so luong co thay doi
                    if($model->so_luong != $oldModel->so_luong){
                        $lichSuTonKho = new KhoVatTuLichSu();
                        $lichSuTonKho->id_kho_vat_tu = $model->id;
                        $lichSuTonKho->id_nha_cung_cap = 1; //1 la chua phan loai, khong duoc xoa danh muc id 1
                        $lichSuTonKho->ghi_chu = 'Sửa số lượng tồn kho';
                        $lichSuTonKho->so_luong = $model->so_luong - $oldModel->so_luong;
                        $lichSuTonKho->so_luong_cu = $oldModel->so_luong;
                        $lichSuTonKho->so_luong_moi = $model->so_luong;
                        $lichSuTonKho->id_mau_cua = null;//*********
                        $lichSuTonKho->save();
                    }               
                    
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Thông tin phụ kiện",
                        'content'=>$this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::a('Edit',['update','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                    ];
                }else{
                    return [
                        'title'=> "Cập nhật phụ kiện",
                        'content'=>$this->renderAjax('update', [
                            'model' => $model,
                        ]),
                        'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
                    ];
                }
            }else{
                return [
                    'title'=> "Cập nhật phụ kiện",
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
     * Delete an existing PhuKien model.
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
     * Delete multiple existing PhuKien model.
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
     * Finds the PhuKien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PhuKien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PhuKien::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
