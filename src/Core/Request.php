<?php

namespace Zarna0x\Core;

class Request 
{
	public static function post( $key )
	{
       if (isset($_POST) && !empty($_POST)  ) {
          return trim(htmlentities(strip_tags($_POST[$key])));
       }

       return false;
	}

	public static function get( $key )
	{
       if (isset($_GET) && !empty($_GET)  ) {
          return trim(htmlentities(strip_tags($_GET[$key])));
       }

       return false;
	}


	public static function rawPost()
	{
		return $_POST;
	}


	public static function rawGet()
	{
		return $_GET;
	}


	public static function rawRequest()
	{
        return $_REQUEST;
	}


	public static function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}
}