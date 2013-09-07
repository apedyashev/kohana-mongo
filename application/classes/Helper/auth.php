<?php

class Helper_Auth{

  public static function login( $inEmail, $inPassword ){
    $user = ORM::factory('user')
            ->where('email', '=', $inEmail)
            ->where('isEnabled', '=', 1)
            ->where('password', '=', md5($inPassword) )
            ->find()
            ;
    
    $isLoggedIn = ( $user->id != 0 );
    if( $isLoggedIn ){
      Auth::instance()->force_login( $inEmail );
    }
    
    return $isLoggedIn;
    
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function logout(){
    Auth::instance()->logout();
  }
  //-----------------------------------------------------------------------------------------------------------------------------
          
  public static function isLoggedIn(){
    
    return Auth::instance()->logged_in();
    
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function getUser(){
      return Auth::instance()->get_user();
//    $user = Auth::instance()->get_user();
//
//    return $user ? ORM::factory( 'user', $user->id ) : false;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function getUserOrm(){
    $user = Auth::instance()->get_user();

    return $user ? ORM::factory( 'user', $user->id ) : false;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function addFamilyUser( $inUserInfo ){
    
    //create new entry in 'users' table
    $user = ORM::factory('user');
    $user->gender        = $inUserInfo['gender'];
    $user->acc_type      = $inUserInfo['acctype'];
    $user->lastname      = $inUserInfo['vorname'];
    $user->firstname     = $inUserInfo['name'];
    $user->email         = $inUserInfo['email'];
    $user->username      = $inUserInfo['email'];
    $user->password      = md5( $inUserInfo['passwort'] );
//    $user->seo_id        = URL::title( $inUserInfo['name'] . ' ' . $inUserInfo['vorname']);

    $user->save();
    
    //save user's SEO friendly ID
    $seoId = URL::title( Helper_Member::getFullName( $user ) );
    if( ORM::factory('user')->where('seo_id', '=', $seoId)->find()->id ){
      $user->seo_id = $seoId . '-' . $user->id;
    }
    else{
      $user->seo_id = $seoId;
    }
    $user->save();
    
    //add role
    $user->add('roles', ORM::factory('role', array('name' => 'login')));
    
    //create new enty in the 'user_infos' table
    $userInfo           = ORM::factory( 'user_info' );
    $userInfo->user_id  = $user->id;
    
    $userInfo->save();
    
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function addCarerUser( $inUserInfo ){
    
    $user = ORM::factory('user');

    $user->gender        = $inUserInfo['gender'];
    $user->acc_type      = $inUserInfo['acctype'];
    $user->lastname      = $inUserInfo['vorname'];
    $user->firstname     = $inUserInfo['name'];
    $user->email         = $inUserInfo['email'];
    $user->username      = $inUserInfo['email'];
    $user->password      = md5( $inUserInfo['passwort'] );
//    $user->seo_id        = URL::title( $inUserInfo['name'] . ' ' . $inUserInfo['vorname']);
    
    $user->save();
    
    //save user's SEO friendly ID
    $seoId = URL::title( Helper_Member::getFullName( $user ) );
    if( ORM::factory('user')->where('seo_id', '=', $seoId)->find()->id ){
      $user->seo_id = $seoId . '-' . $user->id;
    }
    else{
      $user->seo_id = $seoId;
    }
    $user->save();
    
    //add role
    $user->add('roles', ORM::factory('role', array('name' => 'login')));
    
    //Create the first carer's profile
    Helper_Carer::addProfile( $user->id, $inUserInfo['profileType'] );
    
    //create new enty in the 'user_infos' table
    $userInfo           = ORM::factory( 'user_info' );
    $userInfo->user_id  = $user->id;
    
    $userInfo->save();
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function isEmailExist( $inEmail ){
    
    $foundUser = ORM::factory('user')->where('email', '=', $inEmail)->find();
    
    return ($foundUser->id != 0);
  }
  //-----------------------------------------------------------------------------------------------------------------------------

  /**
   *  Checks if OTHER users has given email. Used by validation module
   * 
   * @param type $inEmail
   * @return type
   */
  public static function validateEmailExistence( $inEmail ){
    
    $loggedUserId = self::getUser()->id;
    $foundUser = ORM::factory('user')->
            where('email', '=', $inEmail)->
            where('id', '!=', $loggedUserId)->
            find();
    
    $canEmailbeUsed = ($foundUser->id == 0);
    return $canEmailbeUsed;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function isAdmin(){
    $user = self::getUserOrm();
    
    if( $user ){
      $role = ORM::factory( 'role', array('name' => 'admin') );
//      foreach( $user->roles->find_all() as $role){
//        echo $role->name . " | ";
//      }
//      die;
      return $user->has('roles', $role);
    }
    return false;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function getFullName( ){
    $user = self::getUser();
    $fullName = '';
    if( $user ){
      $fullName = $user->lastname . " " . $user->firstname;
    }
    return $fullName;
  }
  
  
}
?>
