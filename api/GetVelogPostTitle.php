<?php

require_once ('../class/RequestVelogAPI.php');

$request = json_decode(file_get_contents("php://input"), true);

try {
    $RequestVelogAPI = new RequestVelogAPI();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}


$result = array();
$hasNext = true;
$lastPostId = null;

$minDelaySecond = 2;
$maxDelaySecond = 4;

$testCallCount = 3;

while($hasNext) {
    $titleResponse = $RequestVelogAPI->curlTitle("gillog", $lastPostId);
    $titleResponseArray = json_decode($titleResponse, true)['data'];

    foreach($titleResponseArray['posts'] as $post) {
        $lastPostId = $post['id'];
        $postResult = array(
            'id' => $post['id'],
            'title' => $post['title']
        );
        $result[] = $postResult;
    }
    $countPosts = count($titleResponseArray['posts']);
    if($countPosts < 20) {
        $hasNext = false;
    }

    $randomDelaySecond = rand($minDelaySecond, $maxDelaySecond);
    sleep($randomDelaySecond);

    $testCallCount -= 1;
    if($testCallCount == 0) {
        $hasNext = false;
    }
}

echo print_r($result);
