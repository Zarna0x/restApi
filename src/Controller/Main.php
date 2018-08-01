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


	public function __construct()
	{
        $this->_db = new DB;


        
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
}