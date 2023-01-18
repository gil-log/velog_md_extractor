<?php

require_once ('../class/RequestVelogAPI.php');

$request = json_decode(file_get_contents("php://input"), true);

try {
    $RequestVelogAPI = new RequestVelogAPI();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

echo $RequestVelogAPI->curlPost("CMD-명령어로-사용중인-port-종료하기");
