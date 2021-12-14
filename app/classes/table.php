<?php

namespace App\Classes;

use DB;

Class table {

    public static function users() 
    {
      $users = DB::table('users');
      return $users;
    }

public static function people() 
    {
      $people = DB::table('user_details');
      return $people;
    }

    public static function account() 
    {
      $accountdata = DB::table('user_accounts');
      return $accountdata;
    }

    
}