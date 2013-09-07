<?php

class Model_Test extends Model{

  public function run(){
//    $db = Mongo_Database::instance();
//    $posts = new Mongo_Collection('posts');
    
//    $posts = new Mongo_Collection('posts');
//    $v = $posts->sort_desc('published')->limit(10)->as_array(); 
//    var_dump($v);

//    $this->add();
    $post = Mongo_Document::factory('post');
    $searchCriteria = array(
//        "title" => array('$regex' => 's')
        "title" => array('$regex' => new MongoRegex('/^s/i') )
    );
    $foundPosts = $post->load( $searchCriteria );
    var_dump($post->title);
  }
  
  public function add(){
    $post = Mongo_Document::factory('post');
    $post->title = 'Sashiko';
    $post->save();
  }
  
}

?>
