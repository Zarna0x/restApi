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

$router->post('items',[
  'controller' => 'Main',
  'method' => 'getItems'
]);

$router->get('getjson','main@getJson');

$router->get('newendpoint','controller@name');

$router->run();
