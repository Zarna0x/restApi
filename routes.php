<?php

$router = new Zarna0x\Core\Router;


$router->get('',function () {
	echo json_encode([
      'response' => 'homepage'
	]);
});



$router->post('auth',[
  'controller' => 'Main',
  'method' => 'auth'
]);



$router->post('getCustomers',[
  'contoller' => 'customers',
  'method' => 'getCustomers'
]);

$router->get('getjson','main@getJson');

$router->run();