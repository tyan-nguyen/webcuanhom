<?php
namespace app\modules\dungchung\models;

use Yii;
use yii\base\Model;
use app\custom\CustomFunc;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Import extends Model
{
    CONST FOLDER_EXCEL_UP = '/uploads/excel/up/';
    public $file;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'file' => 'File import',
        ];
    }
    
    /**
     * kiem tra file tam upload con ton tai khong
     * @param string $file
     * @return boolean
     */
    public static function checkFileExist($file){
        $fxls = Yii::getAlias('@webroot') . Import::FOLDER_EXCEL_UP . $file;
        if(file_exists($fxls)){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * xoa file excel tam sau khi kiem tra loi hoac import thanh cong
     * @param string $file
     */
    public static function deleteFileTemp($file){
        $fxls = Yii::getAlias('@webroot') . Import::FOLDER_EXCEL_UP . $file;
        if(file_exists($fxls)){
            unlink($fxls);
        }
    }
    
    /**
     * doc file excel va tra ve $spreadsheet
     * @param string $file: ten file
     * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
     */
    public static function readExcel($file){
        $fxls = Yii::getAlias('@webroot') . Import::FOLDER_EXCEL_UP . $file;
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fxls);
        //read excel data and store it into an array and return
        return $spreadsheet;
    }
    
    /**
     * lay mang du lieu tu file excel
     * @param string $file: ten file
     * @return array|mixed|string
     */
    public static function readExcelToArr($file){
        $spreadsheet = Import::readExcel($file);
        return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    }
    
    
    
    /**
     * test not used
     * @param unknown $excelFilePath
     * @param unknown $outputDirectory
     */
    public function extractAndSaveImages($excelFilePath, $outputDirectory) {
        // Load the Excel file
        $spreadsheet = IOFactory::load($excelFilePath);
        
        // Get the active sheet
        $worksheet = $spreadsheet->getActiveSheet();
        
        // Create the output directory if it doesn't exist
        if (!is_dir($outputDirectory)) {
            mkdir($outputDirectory, 0755, true);
        }
        $i=0;
        // Loop through the worksheet's drawing collection
        foreach ($worksheet->getDrawingCollection() as $drawing) {
            $i++;
            // Check if the drawing is an instance of a memory drawing
            /* if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing) {
                // Generate a unique filename for each image
                $filename = uniqid('image_') . '.png';
                
                // Save the image to the output directory
                file_put_contents($outputDirectory . '/' . $filename, $drawing->getImageResource());
                
                echo 'Image extracted and saved successfully: ' . $filename . PHP_EOL;
            } */
            
            $zipReader = fopen($drawing->getPath(),'r');
            $imageContents = '';
            
            while (!feof($zipReader)) {
                $imageContents .= fread($zipReader,1024);
            }
            fclose($zipReader);
            $extension = $drawing->getExtension();
            $filename = '00_Image_'.$i.'.'.$extension;
            file_put_contents($outputDirectory . '/' . $filename, $imageContents);
            
            echo 'lkkkkkkkkkkkkk';
        }
    }
    
    /**
     * lay hinh anh tu file excel
     * @param string $file: ten file
     * @return array|mixed|string
     */
    public static function readImageArr($file){
        $spreadsheet = Import::readExcel($file);
        $outputDirectory = Yii::getAlias('@webroot') . '/uploads/images';
        $cus = new CustomFunc();
        $rtImages = [];
        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
            $extension = $drawing->getExtension();
            $name = date('His-'). $cus->generateRandomString() . '.' . $extension;
            $outputImagePath = Yii::getAlias('@webroot/uploads/images/' . $name);
            
            // Check if the drawing is an instance of a memory drawing
            $zipReader = fopen($drawing->getPath(),'r');
            $imageContents = '';
            
            while (!feof($zipReader)) {
                $imageContents .= fread($zipReader,1024);
            }
            fclose($zipReader);
            file_put_contents($outputDirectory . '/' . $name, $imageContents);
            $rtImages[] = ['fileName' => $name, 'ext' => $extension];
        }
        
        //$rtImages['addbaf372d13766987512e85aced810c.jpg'] = 'xxaddbaf372d13766987512e85aced810c.jpg';
        
        return $rtImages;
    }
    
    /**
     * lay du lieu cot excel theo mot range
     * @param string $file
     * @param string $range, ex: B1:B8
     * @return array|mixed|string
     */
    public static function readExcelColsToArr($file, $range){
        $spreadsheet = Import::readExcel($file);
        return $spreadsheet->getActiveSheet()->rangeToArray($range);
    }
    
    /**
     * convert data colums range in excel to simle array
     * exam: [0=>[0=>a], 1=>[0=>b],] => [a,b,..]
     * @param array $dataArr
     * @return array
     */
    public static function convertColsToSimpleArr($dataArr){
        $list = array();
        foreach ($dataArr as $val){
            if($val[0] != null){
                $list[] = $val[0];
            }
        }
        return $list;
    }
    
    /**
     * convert data column range in excel to sql string "IN" with col name and list
     * exam: "ma_bo_phan IN ('ma1', 'ma2')"
     * @param array $dataArr
     * @param string $colInBb
     * @param bool $isNum
     * @return string
     */
   /*  public static function convertColsToSqlStr($dataArr, $colInBb, $isNum){
        $list = Import::convertColsToSimpleArr($dataArr);
        
        if(!empty($list)){
            if($isNum == true){
                $string = implode(',', $list);
                return $colInBb . ' IN (' . $string . ')';
            } else {
                $string = implode("','", $list);
                return $colInBb . " IN ('" . $string . "')";
            }
        } else 
            return '';
    } */
    
}
