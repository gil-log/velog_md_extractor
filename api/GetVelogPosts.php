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

$minDelaySecond = 1;
$maxDelaySecond = 4;

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
}

foreach($titleResult as $title) {
    $post = json_decode($RequestVelogAPI->curlPostByTitle($title['url_slug']), true)['data']['post'];

    echo $TransferPostToMD->transferToMD($post);
    echo "\n";
}
