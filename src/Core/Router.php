<?php

namespace Zarna0x\Core;

class Router
{
	protected $_uri;

	protected $_routes;

	public function __construct()
	{
        $this->_uri = (isset($_GET['url'])) ? strip_tags(strtolower(trim($_GET['url']))) : '' ;
	}

	public function get($endpoint, $value)
	{
	   $clean = strip_tags(strtolower(trim($endpoint)));
       $this->_routes['GET'][$clean] = $value;
	}

	public function post($endpoint, $value)
	{
		$clean = strip_tags(strtolower(trim($endpoint)));
       $this->_routes['POST'][$clean] = $value;
	}

	public function run()
	{


       $requestMethod = $_SERVER['REQUEST_METHOD'];
        
       
       
       if (array_key_exists($this->_uri, $this->_routes[$requestMethod]) == false) {
          
          Base::errorResponse(Response::ENDPOINT_NOT_FOUND,'endpoint not found with this request method.');
       }

       $endpointInfo = $this->_routes[$requestMethod][$this->_uri];
       

       if (!is_array($endpointInfo) && !is_string($endpointInfo) && !(is_callable($endpointInfo) && $endpointInfo instanceof \Closure)) {
          Base::errorResponse(Response::WRONG_ENDPOINT_INFO,'Wrong route value.'); 
       }

       if (is_callable($endpointInfo) && $endpointInfo instanceof \Closure) {
         call_user_func($endpointInfo);       
         exit;
       }
         
       if (is_array( $endpointInfo )) {
         $controller = ucfirst(trim(strtolower(Base::_('controller',$endpointInfo))));
         $method = trim(strtolower(Base::_('method',$endpointInfo)));
       }

       if ( is_string( $endpointInfo ) ) {
          $explodedEndpInfo = explode('@',$endpointInfo);

          $controller = ucfirst(trim(strtolower(Base::_(0,$explodedEndpInfo))));
          $method = trim(strtolower(Base::_(1,$explodedEndpInfo)));  
       }

        if (empty($method)) {
           Base::errorResponse(Response::WRONG_ENDPOINT_METHOD,'You must specify method for controller');
        }

        $fullControllerClass = "Zarna0x\\Controller\\".$controller;
        
        if (!class_exists($fullControllerClass)) {
          Base::errorResponse(Response::CONTROLLER_NOT_FOUND,'Wrong Controller Specified ');
        }  
       
       $controllerInstance = new $fullControllerClass;

       if (!method_exists($controllerInstance, $method)) {
           Base::errorResponse(Response::METHOD_NOT_FOUND,'Method '.$method.' doesnot exists in controller '.$fullControllerClass); 
       }

       $rMeth = new \ReflectionMethod($controllerInstance,$method);
       $rMeth->invoke($controllerInstance);
	}
}