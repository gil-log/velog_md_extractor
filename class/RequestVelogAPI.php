<?
require_once('RequestCurl.php');

class RequestVelogAPI {
    public $response;
    public $options;
    public $userName;
    private $requestAPIData;

    /**
     * @throws Exception
     */
    function __constrcut($userName, $cookie) {
        if($userName == null || $userName == '') {
            throw new Exception("UserName이 존재하지 않습니다.", 0);
        }
        if($cookie == null || $cookie == '') {
            throw new Exception("Cookie가 존재하지 않습니다.", 1);
        }
        $this->options = array(
            CURLOPT_HTTPHEADER => array(
                'Cache-Control' => 'no-cache',
                'Content-Type' => 'application/json',
                'Accept' => '*/*',
                'cookie' => $cookie
            ),
            CURLOPT_POST => 0,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLINFO_HEADER_OUT => false,
            CURLOPT_HEADER => false,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => 'gzip,deflate',
            CURLOPT_POSTFIELDS => json_encode(array(
                "operationName"=>"PostView",
                "variables"=>array(
                    "id"=>"d9f3c906-23c8-4918-b322-d284eef075d4",
                    "query"=>"mutation PostView($id: ID!) {postView(id: $id)}"
                )
            ), true)
        );

        $this->userName = $userName;
        $this->requestAPIData = new RequestAPIData($this->options);
    }

    function testRequest() {
        $response = $this->requestAPIData->requestAPI('https://v2cdn.velog.io/graphql');

        echo $response;
    }
}
