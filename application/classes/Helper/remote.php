<?php

class Helper_Remote {
  const LINK_TYPE_IMAGE   = 1;
  const LINK_TYPE_PAGE    = 2;
  const LINK_TYPE_UNKNOWN = 3;
  
  public static function getTitleByUrl( $inUrl ){
    $content  = "";
    $handle   = @fopen( $inUrl, "r" );
    
    if ($handle) {
      while (($buffer = fgets($handle, 4096)) !== false) {
          $content .= $buffer;
          if(preg_match("/\<title\>(.*)\<\/title\>/", $content, $title) ){
             $content = $title[1];
             break;
          }
      }
      fclose($handle);
    }
    return $content;
  }
  
  /**
   * Determines link's content type based on Content-Type header
   * 
   * @param type $inLink
   * @return self:: LINK_TYPE_IMAGE for image self::LINK_TYPE_PAGE for text/html or self::LINK_TYPE_UNKNOWN otherwise
   */
  public static function getLinkContentType( $inLink ){
      $headers = get_headers( $inLink );

      if( isset($headers) && is_array($headers) ){
        foreach( $headers as $header ){
          if( strpos( $header, 'Content-Type' ) !== false ){
            if( strpos( $header, 'image' ) !== false ){
              return self::LINK_TYPE_IMAGE;
            }
            else if( strpos( $header, 'html' ) !== false ){
              return self::LINK_TYPE_PAGE;
            }
          }
        }
      }
      
      return self::LINK_TYPE_UNKNOWN;
  }
  //-----------------------------------------------------------------------------------------------------------------------------

}
?>
