<?php

namespace Zarna0x\Core;

class Request 
{
	public static function post( $key )
	{
       return trim(htmlentities(strip_tags($_POST[$key])));
	}

	public static function get( $key )
	{
       return trim(htmlentities(strip_tags($_GET[$key])));
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