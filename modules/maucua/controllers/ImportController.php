<?php

namespace app\modules\maucua\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use app\modules\maucua\models\Import;
use app\modules\maucua\models\CongTrinh;
use app\modules\maucua\models\ImportCongTrinh;

/**
 * Default controller for the `dungchung` module
 */
class ImportController extends Controller
{
     /**
     * Upload file to import
     * @param string $type
     * @return mixed
     */
    public function actionUpload($id, $type)
    {   
        $model = new Import();
        $congTrinh = CongTrinh::findOne($id);
        $request = Yii::$app->request;
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                
                return [
                    'title'=> "Upload file",
                    'content'=>$this->renderAjax('upload', compact('model')),
                    'footer'=> Html::button('Upload',['type'=>"submit"]) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                    
                ];
            }else if($model->load($request->post())){
                $file = UploadedFile::getInstance($model, 'file');
                if (!empty($file)){
                    $fileName = md5(Yii::$app->user->id . date('Y-m-d H:i:s')) . '.' . $file->extension;
                    $file->saveAs(Yii::getAlias('@webroot') . Import::FOLDER_EXCEL_UP .  $fileName);
                    
                    //checkfile
                    /********/
                    if($type==CongTrinh::MODEL_ID && $congTrinh->code_mau_thiet_ke == 'VER.230928'){
                        $rt = ImportCongTrinh::checkFile($congTrinh, $type, $fileName);
                    }
                    
                    $status = false;
                    if(empty($rt)){
                        $status = true;
                    }
                    if($status == true){
                        return [
                            'title'=> "Kiểm tra file dữ liệu",
                            'content'=>$this->renderAjax('checkSuccess'),
                            'footer'=> Html::a('Start Upload',
                                ['import?id='.$id.'&type='.$type.'&file=' . $fileName],
                                ['role'=>'modal-remote']
                            ) . '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                        ];
                    } else {
                        Import::deleteFileTemp($fileName);
                        return [
                            'title'=> "Test file dữ liệu",
                            'content'=>$this->renderAjax('error', compact('rt')),
                            'tcontent'=>'File có lỗi! Vui lòng kiểm tra dữ liệu',
                            'footer'=> Html::a('Back',
                                [Yii::getAlias('@web/maucua/cong-trinh/view'), 'id'=>$id],
                                ['role'=>'modal-remote']). '&nbsp;' .
                            Html::button('Close',['data-bs-dismiss'=>"modal"])
                            
                        ];
                    }
                    
                    
                }
            }
        }
    }
    
    /**
     * import file was checked to db
     * @param string $type
     * @param string $file
     * @return string[]
     */
    public function actionImport($id, $type, $file){
        $request = Yii::$app->request;
        $duAn = CongTrinh::findOne($id);
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                if(Import::checkFileExist($file)){
                    //import file
                    /********/
                    if($type==CongTrinh::MODEL_ID && $duAn->code_mau_thiet_ke == 'VER.230928'){
                        $result = ImportCongTrinh::importFile($duAn, $file);
                    }
                    
                    Import::deleteFileTemp($file);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Kết quả import dữ liệu",
                        'content'=>$this->renderAjax('result', [
                            'model'=>$duAn,
                            'success'=>$result['success'],
                            'error'=>$result['error'],
                            'errorArr'=>$result['errorArr']
                        ]),
                        'footer'=> Html::button('Close',['data-bs-dismiss'=>"modal"])
                        
                    ];
                }
            }
        }
    }

}
