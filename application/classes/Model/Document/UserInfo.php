<?php

class Model_Document_UserInfo extends Mongo_Document{
  protected $name = 'user_info';
  
  protected $_references = array(
    'user'      => array('model' => 'Document_User'),
//    'comments'  => array('model' => 'comment', 'foreign_field' => 'post_id')
  );
}

?>
