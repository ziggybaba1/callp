<?php
namespace App\Traits;
use DB;
use App\Classes\Table;


trait ReferenceTrait {


    public static function generateReferenceNumber() {
        $reference = rand(10*45, 100*98)  . rand(10*45, 100*98). rand(10*45, 100*98);
        return $reference;
    } 

    public static function fakename($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    } 

    // public static function fakeemail() {
    //     $reference = rand(10*45, 100*98)  . rand(10*45, 100*98). rand(10*45, 100*98);
    //     return $reference;
    // } 
}