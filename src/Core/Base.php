<?php

namespace Zarna0x\Core;

class Base
{
	public static function errorResponse ($status, $message) 
	{
      

      echo json_encode([
           'error' => [
              'status' => $status,
              'message' => $message
           ]
       ]);
       exit;
	}

	public function _($Key,$Collection,$Default = '')
	{
	   $Keys = explode('.', $Key);
	   $Data = $Collection;
	   foreach ($Keys as $kkk) {
	   
	       if (is_object($Data)) {
	       	
	           $Data = (array)$Data;
	       } 
	       if (!isset($Data[$kkk])){
	          return $Default;
	       }

	       $Data = $Data[$kkk];
	   }

	   return $Data;
	}
}