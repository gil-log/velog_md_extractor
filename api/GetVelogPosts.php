<?php

require_once ('../class/RequestVelogAPI.php');

$request = json_decode(file_get_contents("php://input"), true);

try {
    $RequestVelogAPI = new RequestVelogAPI($request['userName'], $request['cookie']);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

echo $RequestVelogAPI->testRequest();
