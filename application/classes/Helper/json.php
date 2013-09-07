<?php

class Helper_Json {

  private static $m_IsSuccess = true;
  private static $m_Messages = array();
  private static $m_Data = array();

  /**
   * @name setSuccess
   * @description sets some operation's result 
   * 
   * @param bool $inIsSuccess - success or not
   */
  public static function setSuccess( $inIsSuccess ){
    self::$m_IsSuccess = $inIsSuccess;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  
  /**
   * @name setMessages
   * @description array set contains messages 
   * 
   * @param Array $inMessagesArray
   */
  public static function setMessages( $inMessagesArray ){
    self::$m_Messages = $inMessagesArray;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  /**
   * @name addMessage
   * @description adds new message
   * 
   * @param string $inMessageKey
   * @param string $inMessageValue
   */
  public static function addMessage( $inMessageKey, $inMessageValue ){
    self::$m_Messages[ $inMessageKey ] = $inMessageValue;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  

  /**
   * @name setData
   * @description sets data array
   * 
   * @param Array $inData
   */
  public static function setData( $inData ){
    self::$m_Data = $inData;
  }
  //-----------------------------------------------------------------------------------------------------------------------------

  /**
   * @name addData
   * @description adds data element
   * 
   * @param string $inMessageKey
   * @param string $inMessageValue
   */
  public static function addData( $inMessageKey, $inMessageValue ){
    self::$m_Data[ $inMessageKey ] = $inMessageValue;
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
  /**
   * @name renderAndDie
   * @description prints JSON and exits to prevent further output
   * 
   * @param string $inJsonPCallback if you use JSONP then set this param to JSONP callback
   */
  public static function renderAndDie( $inJsonPCallback = false ){
    $arrayForJson = array(
        'success' => self::$m_IsSuccess,
        'messages' => self::$m_Messages,
        'data' => self::$m_Data
         
    );
    
    header('Content-type: application/json'); 
    
    if( $inJsonPCallback ){
      die( $inJsonPCallback . "(" . json_encode( $arrayForJson ) . ")" );
    }
    else{
      die( json_encode( $arrayForJson ) );
    }
    
  }
  //-----------------------------------------------------------------------------------------------------------------------------
  
}
?>
