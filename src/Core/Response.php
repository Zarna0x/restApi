<?php

namespace Zarna0x\Core;

class Response
{

	/** Error reponses **/
	const ENDPOINT_NOT_FOUND = 100;
   
    
	const WRONG_ENDPOINT_INFO = 503;

	const WRONG_ENDPOINT_METHOD = 504;

	const CONTROLLER_NOT_FOUND = 15;
	
	const METHOD_NOT_FOUND = 16;

	const WRONG_DB_CREDENTIALS = 90;
	
	const NOT_ENOUGH_DATA = 123;

	const WRONG_DB_ARGUMENT = 123413; 

	const WRONG_SQL_QUERY = 223;

	const QUERY_ERROR = 888;

	const WRONG_USER_CREDS = 430;

	const JWT_PROCESSING_ERROR = 890;


	/** Success reponses **/

	const SUCCESS_RESPONSE = 200;
}