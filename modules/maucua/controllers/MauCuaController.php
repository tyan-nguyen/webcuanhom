<?php

namespace app\modules\maucua\controllers;

use Yii;
use app\modules\maucua\models\MauCua;
use app\modules\maucua\models\search\MauCuaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\modules\maucua\models\DuAn;
use app\modules\maucua\models\DuAnChiTiet;
use app\modules\maucua\models\ToiUu;
use app\modules\maucua\models\MauCuaNhom;
use app\modules\maucua\models\MauCuaVatTu;
use app\modules\kho\models\KhoVatTu;
use app\modules\kho\models\KhoVatTuLichSu;
use app\modules\maucua\models\KhoNhom;
use app\modules\maucua\models\KhoNhomLichSu;
use app\modules\maucua\models\MauCuaSettings;
use app\modules\dungchung\models\Setting;
use app\modules\maucua\models\CongTrinh;
use app\widgets\BtnBackForMauCuaWidget;

/**
 * MauCuaController implements the CRUD actions for MauCua model.
 */
class MauCuaController extends Controller
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
     * Lists all MauCua models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new MauCuaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * load phieu xuat kho
     * @return mixed
     */
    public function actionGetPhieuInAjax($idMauCua, $type)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = MauCua::findOne($idMauCua);
        if($model !=null){
            if($type == "phieuthongtin"){
                return [
                    'status'=>'success',
                    'content' => $this->renderAjax('_print_phieu_thong_tin', [
                        'model' => $model
                    ])
                ];
            } else if ($type == "phieuxuatkho"){
                return [
                    'status'=>'success',
                    'content' => $this->renderAjax('_print_phieu_xuat_kho', [
                        'model' => $model
                    ])
                ];
            }
        } else {
            return [
                'status'=>'failed',
                'content' => 'Phiếu xuất kho không tồn tại!'
            ];
        }
    }
    
    /**
     * get data by ajax
     */
    public function actionGetData(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'result'=> [
                [
                    'id' => 11,
                    'soluong' => [
                        [
                            'id' => 1,
                            'width' => rand(100,3000)
                        ],
                        [
                            'id' => 2,
                            'width' => rand(100,3000)
                        ]
                    ],
                    'chieudai' => 5900,
                    'vetcat' => 2,
                    'mincut' => 500
                ],
                [
                    'id' => 11,
                    'soluong' => [
                        [
                            'id' => 4,
                            'width' => rand(100,3000)
                        ],
                        [
                            'id' => 5,
                            'width' => rand(100,2000)
                        ],
                        [
                            'id' => 6,
                            'width' => rand(100,1000)
                        ]
                    ],
                    'chieudai' => 5900,
                    'vetcat' => 2,
                    'mincut' => 500
                ],
                [
                    'id' => 11,
                    'soluong' => [
                    ],
                    'chieudai' => 5900,
                    'vetcat' => 2,
                    'mincut' => 500
                ]
            ]
        ];
    }
    
    /**
     * lay du lieu theo mau cua thuoc du an
     * @param integer $id
     * @return array
     * 
     */
    public function actionGetData2($id, $type=NULL){
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $kqTest = '';
        
        //neu chua co toi uu thi tao moi
        $toiUu = ToiUu::find()->where(['id_mau_cua'=>$id]);
        $nhom = MauCuaNhom::find()->where(['id_mau_cua'=>$id]);
        
        $mauCuaModel = MauCua::findOne($id);
        
        //xoa nhom neu truoc do da toi uu cho tat ca cua thuoc du an
        $duAn = DuAn::findOne($mauCuaModel->id_du_an);
        $duAn->deleteNhomSuDung();
        
        $slToiUu = $toiUu->count();
        //$slNhom = $nhom->sum('so_luong');
       // if( $slToiUu == $slNhom ){
        //    $kqTest = 'số lượng ok';
       // } else {
        //    $kqTest = 'Số lượng k khớp!';
            //kt nếu tối ưu > 0 thì xóa hết.
        if($slToiUu > 0){
            
            $mauCuaModel->deleteNhomSuDung();
            $mauCuaModel->deleteToiUu();
            
        }
        //them moi lai toan bo toi uu
        //duyet qua tung thanh nhom, neu so luong bao nhiu thi tao them bay nhieu thanh
        if($type==NULL){//toi uu tu kho
            //$kqToiUu = $mauCuaModel->taoToiUu();
            //$kqTest .= print_r($kqToiUu); 
            $mauCuaModel->taoToiUu();
        } else if($type == 'catmoi'){
            $mauCuaModel->taoToiUuCatMoi();
        }
        
        if($mauCuaModel->status == "KHOI_TAO"){
            $mauCuaModel->status = "TOI_UU";
            $mauCuaModel->save(false);
        }
        
            
       // }
       //search lai de load model moi
        $mauCuaModel1 = MauCua::findOne($id);
        
        /**
         * toi uu cat hien thi tren cay nhom
         */
        //$mauCuaModel1->taoNhomSuDung();
        
        //tao lai nhom su dun
        $mauCuaModel1->taoNhomSuDung2();
        
        
        
        return [
            'kqTest' => $kqTest,
            'nhomSuDung' => $mauCuaModel1->dsSuDung(),
            'result'=> $mauCuaModel1->dsToiUu() /* [
                [
                    'id' => 112,
                    'idMauCua' => 112,
                    'idCuaNhom' => 222,
                    'idTonKhoNhom' => 332,
                    'maCayNhom' => 'ma0001-1',
                    'tenCayNhom' => 'Cây nhôm abc -1',
                    'chieuDai' => 550,
                    'soLuong' => 1,
                    'kieuCat' => '==\\',
                    'khoiLuong' => 2000,
                    'chieuDaiCayNhom' => 5900
                ],
                [
                    'id' => 1112,
                    'idMauCua' => 1112,
                    'idCuaNhom' => 2222,
                    'idTonKhoNhom' => 3332,
                    'maCayNhom' => 'ma00011-2',
                    'tenCayNhom' => 'Cây nhôm abc2 - 2',
                    'chieuDai' => 600,
                    'soLuong' => 1,
                    'kieuCat' => '==\\',
                    'khoiLuong' => 2000,
                    'chieuDaiCayNhom' => 5900
                ],
            ] */
        ];
    }
    
    /**
     * lay du lieu danh sach phu kien cua mau cua
     * @param integer $id
     * @return array
     *
     */
    public function actionGetDsVatTu($id, $type=NULL){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = MauCua::findOne($id);
        $result = null;
        if($type == 'phukien'){
            $result = $model->dsPhuKienJson();
        } else if ($type == 'vattu'){
            $result = $model->dsVatTuJson();
        }
        return [
            'result'=> $result
        ];
    }


    /**
     * Displays a single MauCua model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $back=NULL, $backid=NULL /*, $dactid=NULL*/)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            //tao back link
            $backLink = '';
            //$dactModel = null;
            if($back != null && $backid != null){
                if($back == DuAn::MODEL_ID){
                    $backLink = [Yii::getAlias('@web/maucua/du-an/view'), 'id'=>$backid];
                    //$dactModel = DuAnChiTiet::findOne($dactid);
                }else if($back == CongTrinh::MODEL_ID){
                    $backLink = [Yii::getAlias('@web/maucua/cong-trinh/view'), 'id'=>$backid];
                    //$dactModel = DuAnChiTiet::findOne($dactid);
                }
            }
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($id);
            return [
                    'title' => "Thông tin Mẫu cửa",
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                        //'dactModel'=>$dactModel
                    ]),
                    'footer' =>                        
                        ($backLink != null ? Html::a('Back',
                            $backLink,
                            ['role'=>'modal-remote']) : '') . '&nbsp' .                                                
                ( ($model->status == 'KHOI_TAO' || $model->status == 'TOI_UU') ? Html::a('Edit',['update','id'=>$id],[
                            'role'=>'modal-remote'
                        ]) : '') . '&nbsp;' .
                /*tam tat (($model->status == 'TOI_UU') ? Html::a('xuatKho',['xuat-kho','id'=>$id],[
                            'role'=>'modal-remote'
                        ]) : '') . '&nbsp;' . */
                        
                       
                        Html::button('Close',['data-bs-dismiss'=>"modal"]) . '&nbsp;' .
                        BtnBackForMauCuaWidget::widget(['model'=>$model, 'type'=>'view'])         
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    
    /**
     * xuat kho
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionXuatKho($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            //xuat kho tung cai sau do chuyen trang thai da xuat kho
            //sauu do chinh sua trang thai du an
            foreach ($model->dsTatCaVatTu as $vt){
                $vatTuModel = KhoVatTu::findOne($vt->id_kho_vat_tu);
                $vatTuModelOld = KhoVatTu::findOne($vt->id_kho_vat_tu);
                $vatTuModel->so_luong = $vatTuModel->so_luong - $vt->so_luong;
                if($vatTuModel->save()){
                    if($vatTuModel->so_luong != $vatTuModelOld->so_luong){
                        $lichSuTonKho = new KhoVatTuLichSu();
                        $lichSuTonKho->id_kho_vat_tu = $vatTuModel->id;
                        $lichSuTonKho->id_nha_cung_cap = 1; //1 la chua phan loai, khong duoc xoa danh muc id 1
                        $lichSuTonKho->ghi_chu = 'Xuất kho mẫu cửa #' . $model->code;
                        $lichSuTonKho->so_luong = $vt->so_luong;
                        $lichSuTonKho->so_luong_cu = $vatTuModelOld->so_luong;
                        $lichSuTonKho->so_luong_moi = $vatTuModel->so_luong;
                        $lichSuTonKho->id_mau_cua = $model->id;
                        $lichSuTonKho->save();
                    }
                }
            }
            foreach ($model->dsNhomSuDung as $nhomsd){
                $tonKhoNhom = KhoNhom::findOne($nhomsd->id_kho_nhom);
                $tonKhoNhomOld = KhoNhom::findOne($nhomsd->id_kho_nhom);
                $tonKhoNhom->so_luong = $tonKhoNhom->so_luong - 1;//1 is 1 dong trong nhom sd
                if($tonKhoNhom->save()){
                    if($tonKhoNhom->so_luong != $tonKhoNhomOld->so_luong){
                        $history = new KhoNhomLichSu();
                        $history->id_kho_nhom = $tonKhoNhom->id;
                        $history->so_luong = 1;//1 is 1 dong trong nhom sd
                        $history->so_luong_cu = $tonKhoNhomOld->so_luong;
                        $history->so_luong_moi = $tonKhoNhom->so_luong;
                        $history->id_mau_cua = $model->id;
                        $history->noi_dung = 'Xuất kho mẫu cửa #'. $model->code;
                        $history->save();
                    }
                }
                
            }
            
            $model->status = 'DA_XUAT_KHO';
            if($model->save()){
                //thay doi trang thai du an
                $duAn = DuAn::findOne($model->id_du_an);

                $hoanThanh=true;
                foreach ($duAn->mauCuas as $j=>$cua){
                    if($cua->status == 'KHOI_TAO' || $cua->status == 'TOI_UU'){
                        $hoanThanh = false;
                    }
                }
                if($hoanThanh==true){
                    $duAn->trang_thai = 'HOAN_THANH';
                    $duAn->save();
                } else {
                    $duAn->trang_thai = 'THUC_HIEN';
                    $duAn->save();
                }
                
            }
            
            return [
                'forceReload'=>'#crud-datatable-pjax',
                'title'=> "Thông tin mẫu cửa",
                'content'=>$this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer' =>
                    Html::a('Edit',['update','id'=>$id],[
                        'role'=>'modal-remote'
                    ]) . '&nbsp;' .
                ( ($model->status == 'KHOI_TAO' || $model->status == 'TOI_UU') ? Html::a('xuatKho',['xuat-kho','id'=>$id],[
                        'role'=>'modal-remote'
                    ]) : '') . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
            ];

        }
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
                        // 'forceReload'=>'#crud-datatable-pjax',
                        'forceClose'=>true,
                        'runFunc'=>true,
                        'runFuncVal1'=>$model->id,
                        'runFuncVal2'=>$model->so_luong
                        /* 'title'=> "Create new DonViTinh",
                         'content'=>'<span class="text-success">Create DonViTinh success</span>',
                         'footer'=> Html::a('Create More',['create'],['role'=>'modal-remote']) . '&nbsp;' .
                         Html::button('Close',['data-bs-dismiss'=>"modal"])*/
                        
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
     * sua cau hinh cua mau cua
     */
    public function actionSuaCauHinh($id)
    {
        $request = Yii::$app->request;
        $model = MauCuaSettings::findOne(['id_mau_cua'=>$id]);
        //create setting if not exist
        if($model==null){
            $globalSetting = Setting::find()->one();
            $model = new MauCuaSettings();
            $model->id_mau_cua = $id;
            $model->vet_cat = $globalSetting->vet_cat != null ? $globalSetting->vet_cat : 0;
            $model->save();
        }
        
        if($request->isAjax){
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Chỉnh sửa cấu hình",
                    'content'=>$this->renderAjax('_update_setting', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save-Popup',['type'=>'submit']) . '&nbsp;' .
                    Html::button('Close-Popup',['data-bs-dismiss'=>'modal'])
                ];
            }else if($model->load($request->post()) && $model->save()){
                
                    return [
                        // 'forceReload'=>'#crud-datatable-pjax',
                        'forceClose'=>true,
                        'runFunc2'=>true,
                        'runFunc2Val1'=>$this->renderAjax('_viewSetting', [
                            'setting'=>$model->mauCua->setting
                        ]),
                        //'runFuncVal2'=>$model->so_luong                        
                    ];
            }else{
                return [
                    'title'=> "Chỉnh sửa số lượng",
                    'content'=>$this->renderAjax('_update_setting', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save-Popup',['type'=>"submit"]) . '&nbsp;' .
                    Html::button('Close-Popup',['data-bs-dismiss'=>"modal"])
                ];
            }
        }
        
    }

    /**
     * Creates a new MauCua model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new MauCua();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mẫu cửa",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mẫu cửa",
                    'content'=>'<span class="text-success">Thêm mới mẫu cửa thành công!</span>',
                    'footer'=> Html::a('Create More',['create'],['role'=>'modal-remote']) . '&nbsp;' .
                    Html::button('Close',['data-bs-dismiss'=>"modal"])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new MauCua",
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
     * Updates an existing MauCua model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Chỉnh sửa mẫu cửa",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                        Html::a('Cancel',['view','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"]) . '&nbsp;' .
                        BtnBackForMauCuaWidget::widget(['model'=>$model, 'type'=>'update'])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thông tin mẫu cửa",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::a('Edit',['update','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                        Html::button('Close',['data-bs-dismiss'=>"modal"]) . '&nbsp;' .
                        BtnBackForMauCuaWidget::widget(['model'=>$model, 'type'=>'update'])
                ];    
            }else{
                 return [
                    'title'=> "Chỉnh sửa mẫu cửa",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                     'footer'=> Html::button('Save',['type'=>"submit"]) . '&nbsp;' .
                         Html::a('Cancel',['view','id'=>$id],['role'=>'modal-remote']) . '&nbsp;' .
                         Html::button('Close',['data-bs-dismiss'=>"modal"]) . '&nbsp;' .
                         BtnBackForMauCuaWidget::widget(['model'=>$model, 'type'=>'update'])
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
     * Delete an existing MauCua model.
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
     * Delete multiple existing MauCua model.
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
     * Finds the MauCua model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MauCua the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MauCua::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
