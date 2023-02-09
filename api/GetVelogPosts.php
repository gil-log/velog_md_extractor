<?php

require_once ('../class/RequestVelogAPI.php');
require_once ('../class/TransferPostToMD.php');

$request = json_decode(file_get_contents("php://input"), true);

try {
    $RequestVelogAPI = new RequestVelogAPI();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

$TransferPostToMD = new TransferPostToMD();


$titleResult = array();
$hasNext = true;
$lastPostId = null;

$minDelaySecond = 2;
$maxDelaySecond = 4;

$testCallCount = 1;

while($hasNext) {
    $titleResponse = $RequestVelogAPI->curlTitle("gillog", $lastPostId);
    $titleResponseArray = json_decode($titleResponse, true)['data'];

    foreach($titleResponseArray['posts'] as $post) {
        $lastPostId = $post['id'];
        $postResult = array(
            'id' => $post['id'],
            'title' => $post['title'],
            'url_slug' => $post['url_slug']
        );
        $titleResult[] = $postResult;
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

foreach($titleResult as $title) {
    //echo $title['title'];
    //echo $title['url_slug'];
    //echo $RequestVelogAPI->curlPostByTitle($title['url_slug']);
    $post = json_decode($RequestVelogAPI->curlPostByTitle($title['url_slug']), true)['data']['post'];

    //print_r($TransferPostToMD->transferToMD($post));
    echo $TransferPostToMD->transferToMD($post);


    //echo "\n";
    //$spaceReplaceTitle = preg_replace('/[\\s]/', '-', $title['title']);
    //$specialCharactorReplaceTitle = preg_replace('/[!?\[\]();,]/', '', $spaceReplaceTitle);
    //echo $specialCharactorReplaceTitle;
    echo "\n";
    //echo $RequestVelogAPI->curlPostByTitle($specialCharactorReplaceTitle);
    echo "\n";
}

//echo $RequestVelogAPI->curlPost("[Window]telnet 명령어 설정 및 port ping 확인 하기");
