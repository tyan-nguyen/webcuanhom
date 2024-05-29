<?php

namespace app\custom;


use webvimark\modules\UserManagement\models\User;

class CustomFunc 
{    
    /**
     * lay ten tai khoan boi userID
     * @param int $userID
     * @return string
     */
    public function getTenTaiKhoan($userID){
        $model = User::findOne($userID);
        return $model!=NULL?$model->username:'';  
    }
    
    /**
     * chuyen doi ngay chuoi Y-m-d H:i:s -> dd/mm/yyyy H:i:s
     * @param string $date_string
     * @return string
     */
    public function convertYMDHISToDMYHIS($date_string){
        return $date_string!=null ? date("d/m/Y (H:i:s)", strtotime($date_string)) : '';
    }
    
    /**
     * chuyen doi ngay chuoi Y-m-d -> dd/mm/yyyy
     * @param string $date_string
     * @return string
     */
    public function convertYMDToDMY($date_string){
        return $date_string!=null ? date("d/m/Y", strtotime($date_string)) : '';
    }
    
    /**
     * chuyen doi ngay chuoi dd/mm/yyyy -> Y-m-d để lưu CSDL
     * @param string $date_string
     * @return string
     */
    public function convertDMYToYMD($date_string){
        if($date_string != null){
            $date_string = str_replace('/', '-', $date_string);
            return date("Y-m-d", strtotime($date_string));
        } else 
            return '';
    }
    
    /**
     * generate random 4 string or number
     */
    function generateRandomString() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        
        // Shuffle the characters
        $shuffledCharacters = str_shuffle($characters);
        
        // Take the first 4 characters
        $randomString = substr($shuffledCharacters, 0, 4);
        
        return $randomString;
    }
    
    /**
     * doc so tien thanh chu
     */
    function chuyenSoTienThanhChu($number) {
        $hyphen      = ' ';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'âm ';
        $decimal     = ' phẩy ';
        $dictionary  = array(
            0                   => 'không',
            1                   => 'một',
            2                   => 'hai',
            3                   => 'ba',
            4                   => 'bốn',
            5                   => 'năm',
            6                   => 'sáu',
            7                   => 'bảy',
            8                   => 'tám',
            9                   => 'chín',
            10                  => 'mười',
            11                  => 'mười một',
            12                  => 'mười hai',
            13                  => 'mười ba',
            14                  => 'mười bốn',
            15                  => 'mười năm',
            16                  => 'mười sáu',
            17                  => 'mười bảy',
            18                  => 'mười tám',
            19                  => 'mười chín',
            20                  => 'hai mươi',
            30                  => 'ba mươi',
            40                  => 'bốn mươi',
            50                  => 'năm mươi',
            60                  => 'sáu mươi',
            70                  => 'bảy mươi',
            80                  => 'tám mươi',
            90                  => 'chín mươi',
            100                 => 'trăm',
            1000                => 'nghìn',
            1000000             => 'triệu',
            1000000000          => 'tỷ',
            1000000000000       => 'nghìn tỷ',
            1000000000000000    => 'nghìn triệu triệu',
            1000000000000000000 => 'tỷ tỷ'
        );
        if (!is_numeric($number)) {
            return false;
        }
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
                );
            return false;
        }
        if ($number < 0) {
            return $negative . chuyenSoTienThanhChu(abs($number));
        }
        $string = $fraction = null;
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->chuyenSoTienThanhChu($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->chuyenSoTienThanhChu($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->chuyenSoTienThanhChu($remainder);
                }
                break;
        }
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        return $string;
    }
}