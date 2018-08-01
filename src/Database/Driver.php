<?php

namespace Zarna0x\Database;

use PDO;
use PDOException;
use Zarna0x\Core\Base;
use Zarna0x\Core\Response;


class Driver
{
	protected $_pdo;


	public function __construct()
	{ 

		try {

			$this->_pdo = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME,Config::DB_USER,Config::DB_PASS);
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  

		} catch (PDOException $e) {
           Base::errorResponse(Response::WRONG_DB_CREDENTIALS,$e->getMessage());
		}

	}


	public function select ($sql,$args = null) 
	{

	  try {

	  	 if( empty($sql) ) {
            Base::errorResponse(Response::WRONG_SQL_QUERY,'SQL query dont have to be empty');
	    }


       $stmt = $this->_pdo->prepare($sql);
        
       if (!is_null($args) && is_array($args)) {
         $stmt->execute($args);
       } else {
          $stmt->execute();
       }


       return $stmt->fetch(PDO::FETCH_ASSOC);

      

	  } catch ( PDOException $e ) {
          Base::errorResponse(Response::QUERY_ERROR,$e->getMessage());
	  }

	}
}