<?php

class Helper_Output{

  public static function print_r( $inWhat ){
    echo "<pre>";
    print_r( $inWhat );
    echo "</pre>";
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  /**
   * 
   * @param ORMobj $inUser user which avatar you need
   */
  public static function getUserAvatar( $inUser ){
    
    $avatarFile = Helper_Env::getAvatarDir( $inUser->id ) . $inUser->info->avatar;
    if( empty($inUser->info->avatar) || !file_exists($avatarFile) ){
      if( $inUser->gender == 'man' ){
        $avatarFile = Helper_Env::getDefaultAvatarsDir() . 'man.jpg';
      }
      else{
         $avatarFile = Helper_Env::getDefaultAvatarsDir() . 'woman.jpg';
      }
    }
    
    return URL::site( $avatarFile );
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function getUserAvatarFromArray( $inUserDataArray ){
    
    $avatarFile = Helper_Env::getAvatarDir( $inUserDataArray['user_id'] ) . $inUserDataArray['avatar'];
    if( empty($inUserDataArray['avatar']) || !file_exists($avatarFile) ){
      if( $inUserDataArray['gender'] == 'man' ){
        $avatarFile = Helper_Env::getDefaultAvatarsDir() . 'man.jpg';
      }
      else{
         $avatarFile = Helper_Env::getDefaultAvatarsDir() . 'woman.jpg';
      }
    }
    
    return URL::site( $avatarFile );
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function strDateToMySqlDate( $inStrDate ){
    $dob = DateTime::createFromFormat( Kohana::$config->load('config')->get('date.format'), $inStrDate );
    return $dob->format('Y-m-d');
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function mySqlDateToStrDate( $inMySqlDate ){
    if( empty( $inMySqlDate ) ){
      return '';
    }
    else{
      $dob = DateTime::createFromFormat( 'Y-m-d', $inMySqlDate );
      return $dob->format( Kohana::$config->load('config')->get('date.format') );
    }
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function getCurrentMySqlDateTime(){
    return date('Y-m-d H:i:s');
  }
  
  public static function getCurrentMySqlDate(){
    return date('Y-m-d');
  }
  
  public static function mySqlDateTimeToStrDate( $inMySqlDate ){
    if( empty( $inMySqlDate ) ){
      return '';
    }
    else{
      $dob = DateTime::createFromFormat( 'Y-m-d H:i:s', $inMySqlDate );
      return $dob->format( Kohana::$config->load('config')->get('date.format') );
    }
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function mySqlDateToAge( $inMySqlDate ){
    if( empty( $inMySqlDate ) ){
      return '';
    }
    else{
      $dateNow = new DateTime();
      $dob = DateTime::createFromFormat( 'Y-m-d', $inMySqlDate );
      
      $dateInterval = $dateNow->diff( $dob );
      
      return $dateInterval->y;
    }
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function timeStampToMySqlDate( $inTimeStamp ){
    return date('Y-m-d', $inTimeStamp);
  }


  public static function validateStrDate( $inStrDate ){
    return DateTime::createFromFormat( Kohana::$config->load('config')->get('date.format'), $inStrDate );
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function setFlashData( $inDataId, $inData ){
      Session::instance()->set( $inDataId, $inData );
  }
  //-----------------------------------------------------------------------------------------------------------------------------

  public static function getFlashData( $inDataId ){
      return Session::instance()->get_once( $inDataId, false );
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function getUserDocumentHtml( $inUserId, $inDocument ){
    $docHtml = '';
    if( $inDocument->name ){
      $pathParts = pathinfo( $inDocument->name );
      switch( $pathParts['extension'] ){
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'png':
          $docUrl = $imgUrl = URL::site( Helper_Env::getDocsDir($inUserId) . $inDocument->name );
//          $docHtml = '<a target="_blank" href="' . $imgUrl . '"><img class="pic-admin-preview" src="' . $imgUrl . '"/></a>';
          $docHtml = View::factory('admin/partials/doc_thumb')->
                  set('imgUrl', $imgUrl)->
                  set('docUrl', $docUrl)->
                  set('doc', $inDocument)->render();
          break;
        case 'pdf':
          $imgUrl = URL::site( Helper_Env::getDefaultFilesDir() . "pdf_logo.png" );
          $docUrl = URL::site( Helper_Env::getDocsDir($inUserId) . $inDocument->name );
          $docHtml = View::factory('admin/partials/doc_thumb')->
                  set('imgUrl', $imgUrl)->
                  set('docUrl', $docUrl)->
                  set('doc', $inDocument)->render();
          break;
      }
    }
    
    return $docHtml;
  }
  
  
  public static function getDayOfWeekById( $inDayId ){
    $days = array('Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Sonnabend', 'Sonntag');
    return $days[$inDayId - 1];
  }
  
  public static function getDateFormat(){
    return Kohana::$config->load('config')->get('date.format');
  }
  
  public static function getDateFormatJs(){
    return Kohana::$config->load('config')->get('date.format.js');
  }
  
  public static function getTodayDate(){
    return date( self::getDateFormat() );
  }
}

?>
