<?php

namespace camaleon\helpers;

/**
 * Description of DataTimeManager
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class DataTimeManager {
    private  static $singleTime = "abc";
    
    //put your code here
    function __construct() {}
    private static function getCurrentDate() {
        $singleTime = time ();
        return $singleTime;
    }

    private static function getCurrentTime () {}

    public static function getFullDateTime () {
        $temp = self::$singleTime;
        $fullTime = date("r"). " experimental:: ". $temp ;
        return $fullTime;
    }
    public static function getFormatDate($delimitador = '-', $orden = 1) {
        $date = self::getCurrentDate();
        $returnDate = null;
        if ( $orden == 1){
            if ($delimitador == '-'){
                $returnDate = date('Y-m-d', $date);
            }elseif ($delimitador == '/') {
                $returnDate = date('Y/m/d', $date);
            }            
        } elseif ($orden == 0){
             if ($delimitador == '-'){
                $returnDate = date('d-m-Y', $date);
            }elseif ($delimitador == '/') {
                $returnDate = date('d/m/Y', $date);
            }              
        }
        return $returnDate;
    }
    
    public static function getFormatTime($delimitador = ':', $orden = 1) {
        $date = self::getCurrentDate();
        $returnDate = null;
        if ( $orden == 1){
            if ($delimitador == ':'){
                $returnDate = date('H:i:s', $date);
            }elseif ($delimitador == '/') {
                $returnDate = date('H-i-s', $date);
            }            
        } elseif ($orden == 0){
            if ($delimitador == '-'){
                $returnDate = date('s:i:H', $date);
            }elseif ($delimitador == '/') {
                $returnDate = date('s-i-H', $date);
            }              
        }
        return $returnDate;        
    }
}