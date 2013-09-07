<?php

class Model_Document_User extends Mongo_Document{
  protected $name = 'user';
  protected $_references = array(
    'info'      => array('model' => 'Document_UserInfo'),
//    'comments'  => array('model' => 'comment', 'foreign_field' => 'post_id')
  );
}

?>
