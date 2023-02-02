<?php

require_once ('../class/RequestVelogAPI.php');

$request = json_decode(file_get_contents("php://input"), true);

try {
    $RequestVelogAPI = new RequestVelogAPI();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

echo $RequestVelogAPI->curlPost("gil.log210909");
//echo $RequestVelogAPI->curlTitle("gillog", 'd004d95c-415d-4c9f-b60d-cdbfde20a03f');
