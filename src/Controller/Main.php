<?php

namespace Zarna0x\Controller;

use Firebase\JWT\JWT;
use Zarna0x\Core\Request;
use Zarna0x\Core\Response;
use Zarna0x\Core\Base;
use Zarna0x\Database\Driver as DB;


class Main
{
	protected $_db;

	protected $currentUser;

	public function __construct()
	{
        $this->_db = new DB;
        
        if (Base::getCurrentUrl() !== 'auth') {
           $this->validateToken();
        }
        
	}

	public function auth()
	{
       // Generate Token 
       $email = Request::post('email');

       $pass = Request::post('pass');


      if (empty($email) || empty($pass)) {
           Base::errorResponse(Response::NOT_ENOUGH_DATA,'email and pass doesnot have to be empty');
       }

       
       $user = $this->_db->select("SELECT id FROM users WHERE email=? AND pass=?",[
          $email,$pass
       ]);

       if ( $user == false ) {
          Base::errorResponse(Response::WRONG_USER_CREDS,'Email or Password is incorect');
       }

       // GENERATE TOKEN
       
        $payload = [
         'iat' => time(),
         'iss' => 'localhost',
         'exp' => time() + (15*60),
         'userId' => $user['id']
        ];

       try {

       	 $token = JWT::encode($payload,JWT_SECRET_KEY);

       	 Base::sendResponse(Response::SUCCESS_RESPONSE,[
           'token' => $token
       	 ]);

       } catch (\Exception $e) {
           Base::errorResponse(Response::JWT_PROCESSING_ERROR,'Cannot create token');
       }

		#request_token -> get_token -> make request with token 
	}

	private function getAuthToken()
	{

		if (isset($_SERVER['Authorization'])) {
	            $headers = trim($_SERVER["Authorization"]);
	    }else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
	            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
	    }else if (!empty(Base::_('Authorization',getallheaders()))) {
             $headers = trim(Base::_('Authorization',getallheaders()));
        }else if (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
	            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
	            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
	            if (isset($requestHeaders['Authorization'])) {
	                $headers = trim($requestHeaders['Authorization']);
	            }

	    }

	    if (!empty($headers)) {
	            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
	                return $matches[1];
	            }
	        }
	        $this->throwError( ATHORIZATION_HEADER_NOT_FOUND, 'Access Token Not found');


	}

	public function validateToken () 
	{
		try {

		 $payload = JWT::decode($this->getAuthToken(),JWT_SECRET_KEY,['HS256']);

		 $userId = Base::_('userId',$payload);
         
         $user = $this->_db->select("SELECT * FROM users WHERE id=? ",[$userId]);

         if ( $user == false ) {
            Base::errorResponse(Response::WRONG_USER_CREDS,'Wrong User');
         }


         $this->currentUser = $userId;

		} catch(\Exception $e) {
          Base::errorResponse(Response::ACCESS_TOKEN_ERROR,$e->getMessage());
		}
		
	}

	public function getItems()
	{
		if (empty ($this->currentUser) ) {
            Base::errorResponse(Response::ACCESS_TOKEN_ERROR,"Check access token");
		}

		
	}
}