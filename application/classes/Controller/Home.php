<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller {

	public function action_index()
	{
		Model::factory('Test')->run();
    die;
    
    $user =  Model::factory('Document_User');
    $user->load( array('login' => 'sashka') );
    Helper_Output::print_r( $user->info->fullname );
    
//    Helper_Output::print_r( $auth->getLoggedUser() );
//  $auth = Model::factory('MongoAuth');
//    echo 'Login: ';
//    var_dump( $auth->login('sashka', '123456') );
//    
//    echo '<br/>Adding user: ';
//    $auth->addUser( array('login' => 'sashka', 'password' => '123456'), array('fullname' => 'Sashenka Morozov') );
//    
//    echo '<br/>Login: ';
//    var_dump( $auth->login('sashka', '123456') );
	}

} // End Welcome
