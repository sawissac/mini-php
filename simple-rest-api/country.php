<?php

header('Content-Type: application/json');

require_once 'country-list.php';

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'get'){
  require_once 'get.php';
}

// api
// server -> api -> application

// http ,https = hyper text transfer protocol
// https -> server

// data -> server
// data -> encode ->server->decode

// api structure
// https://localhost/contry => do not contain extension
// https://localhost/contry => don't save info
// https://localhost/movie/horror?limit=5&start=m ?limitation