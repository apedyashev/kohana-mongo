<?php

class Model_MongoAuth extends Model{
  
  private $_userDocumentName      = 'Document_User';
  private $_userInfoDocumentName  = 'Document_UserInfo';
  private $_loginInfoSchema   = array();
  
  public function __construct(){
//    parent::__construct();
    $this->_loginInfoSchema = array(
      //login name
      'login'           => '',
      //encrypted password
      'password'        => '',
      //total number of logins
      'logins_count'    => 0,
       //last activity timestamp
      'last_activity'   => time(),
      //date of creation
      'created_at'      => time(),
      'active'          => true
    );
  }
  /**
   * Checks if user with login and pass is exists and returns TRUE or FALSE otherwise
   * 
   * @param type $inUser
   * @param type $inPass
   * @param type $inRemember
   */
  public function login( $inLogin, $inPass, $inRemember = false ){
    $isUserFound = $this->_isUserExist($inLogin, $inPass, $user);
    if( $isUserFound ){
      $user->inc('logins_count');
      $user->last_activity = time();
      $user->save()->load();
      
      Session::instance()->set('user', $user);
    }
    
    return $isUserFound;
  }
  
  /**
   * Destoys user's session 
   */
  public function logout(){
     Session::instance()->delete('user');
  }
  
  /**
   * Returns logged user data from session
   * 
   * @return type
   */
  public function getLoggedUser(){
    return Session::instance()->get('user', false);
  }
  
  /**
   * Creates a new user
   * 
   * If login name is not available then throws ErrorException
   * 
   * @param array $inLoginInfo
   *                $inLoginInfo['login']     - mandatory
   *                $inLoginInfo['password']  - mandatory
   * @param array $inPersonalInfo
   * @throws ErrorException
   */
  public function addUser( array $inLoginInfo, array $inPersonalInfo = null ){
    $isLoginAvailable = $this->_isLoginAvailable( $inLoginInfo['login'] );
    if( !$isLoginAvailable ){
      /*
       * login namem is available
       */

      $inLoginInfo['password'] = $this->_calculatePassword( $inLoginInfo['password'] );
              
      //merge passed login info to default schema
      $loginInfo = array_merge( $this->_loginInfoSchema, $inLoginInfo);
      
//      Helper_Output::print_r($loginInfo); die;
      
      //save user's document
      $user = Mongo_Document::factory( $this->_userDocumentName );
      foreach( $loginInfo  as $curFieldName => $curFieldValue ){
        $user->{$curFieldName} = $curFieldValue;
      }
      
      $user->info = Mongo_Document::factory( $this->_userInfoDocumentName );
      foreach( $inPersonalInfo  as $curFieldName => $curFieldValue ){
        $user->info->{$curFieldName} = $curFieldValue;
      }
      $user->info->user = $user;
      $user->info->save();
      
      $user->save();
       
      //save user's info document
//      $userInfo = Mongo_Document::factory( $this->_userInfoDocumentName );
//      foreach( $inPersonalInfo  as $curFieldName => $curFieldValue ){
//        $userInfo->{$curFieldName} = $curFieldValue;
//      }
      
//      $userInfo->user = $user;
//      $userInfo->save();
    }
    else{
      /*
       * login namem is not available
       */
      throw new ErrorException('User with given login already exists');
    }
  }
  
  
  
  
  /****************************************************************************
   *              PRIVATE FUNCTION
   ***************************************************************************/
  private function _isUserExist( $inLogin, $inPass, &$outUserData ){
    $user = Mongo_Document::factory($this->_userDocumentName );
    
    $searchCriteria = array('login' => $inLogin, 'password' => $this->_calculatePassword($inPass), 'active' => true );
    $isUserFound = $user->load( $searchCriteria );
    
    $outUserData = false;
    if($isUserFound){
      $outUserData = $user;
    }
    
    return $isUserFound;
  }
  
  private function _isLoginAvailable( $inLogin ){
    $searchCriteria = array('login' => $inLogin );
    $user = Mongo_Document::factory( $this->_userDocumentName );
    $isUserFound = $user->load( $searchCriteria );
    
    return $isUserFound;
  }


  private function _calculatePassword( $inPassword ){
    return md5( $inPassword );
  }
  
}

?>
