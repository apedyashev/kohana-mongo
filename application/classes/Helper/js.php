<?php
/**
 * This helper is designed to export PHP variables int JS varibles
 */
class Helper_Js {
  private static $_vars = array();

  /**
   * Adds variable. 
   * 
   * Limitation:  In case if $inVarName is chanain of nested object, then you 
   * should take care about exisinse of all nestsed objects in the chain
   * 
   * @param type $inVarName
   * @param type $inVarVal
   */
  public static function addVar( $inVarName, $inVarVal ){
    self::$_vars[$inVarName] = $inVarVal;
  }
  
  public static function render(){
    echo '<script type="text/javascript">';
    foreach( self::$_vars as $varName => $varVal ){
      echo "{$varName} = $varVal";
    }
    echo '</script>';
  }
}
?>
