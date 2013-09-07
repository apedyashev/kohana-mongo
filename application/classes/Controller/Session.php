<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Session extends Controller {

	public function action_login(){
    $login      = $this->request->post('login');
    $password   = $this->request->post('password');
    
    $isLoggedIn = Model::factory('MongoAuth')->login($login, $password);
    if( $isLoggedIn ){
      
    }
    else{
      $this->redirect( URL::site('session/login') );
    }
	}
  
  public function action_logout(){
    $isLoggedIn = Model::factory('MongoAuth')->logout();
  }

} // End Session
