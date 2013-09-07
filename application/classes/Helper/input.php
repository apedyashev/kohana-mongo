<?php

class Helper_Input{

  public static function get( $inKey, $inDefaultValue ){
    if( !empty( $_GET[$inKey] ) ) {
      return $_GET[$inKey];
    }
    
    return $inDefaultValue;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
    
  /**
   * Converts checkbox value (on/off) to 1 or 0
   */
  public static function getCheckboxValue( $inCheckboxValue ){
    return ($inCheckboxValue == 'on')?1:0;
  }
  
  public static function xssClean($str){
    return htmlspecialchars( stripslashes ($str) );
  }

}

?>
