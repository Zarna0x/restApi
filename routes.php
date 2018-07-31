<?php

$router = new Zarna0x\Core\Router;

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