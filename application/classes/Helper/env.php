<?php

class Helper_Env {

  public static function getDocsDir( $inUserId ){
    if( $inUserId == 0 ){
      return false;
    }

    $docsDir = str_replace( '{{{USER_ID}}}', $inUserId, Kohana::$config->load( 'config' )->get('user.docs.dir.pattern'));
    return self::createDir( $docsDir ) ? $docsDir : false;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function getAvatarDir( $inUserId ){
    if( $inUserId == 0 ){
      return false;
    }

    $avatarDir = str_replace( '{{{USER_ID}}}', $inUserId, Kohana::$config->load( 'config' )->get('user_avatar_dir_pattern'));
    return self::createDir( $avatarDir ) ? $avatarDir : false;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
 
  public static function getTempDir(){
    return Kohana::$config->load( 'config' )->get('tmp_dir');
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  public static function createDir( $inDir ){
    if( @is_dir($inDir) ){
      return true;
    }
    else{
      if( @mkdir( $inDir,  0755, true ) ){
        if( @is_dir($inDir) ){
          return true;
        }
      }
    }
    
    return false;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  /**
   * returns path to dir which contains default avatars
   */
  public static function getDefaultAvatarsDir(){
    $defAvatarsDir = Kohana::$config->load( 'config' )->get('def_avatars_dir');
    self::createDir( $defAvatarsDir );
    return $defAvatarsDir;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  /**
   * returns path to "defaults" files dir
   */
  public static function getDefaultFilesDir(){
    $defFilesDir = Kohana::$config->load( 'config' )->get('def_files_dir');
    self::createDir( $defFilesDir );
    return $defFilesDir;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
}
?>
