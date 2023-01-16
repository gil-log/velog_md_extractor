<?

class RequestAPIData
{
    public $arrCurlOptions;

    function __construct($arrCurlOptions)
    {
        $this->arrCurlOptions = $arrCurlOptions;
    }

    function requestAPI($url)
    {
        $cURL = curl_init();
        $header = '';
        $htmlSource = 'error';

        $this->arrCurlOptions[CURLOPT_URL] = $url;

        if( curl_setopt_array( $cURL, $this->arrCurlOptions ) ) {
            if (($htmlSource = curl_exec($cURL)) === false) {
                $htmlSource = curl_exec($cURL);
            }

        }

        if(preg_match_all('!(HTTP/.*?(?:\s){4,})!s', $htmlSource, $arrSet)){
            if(isset($arrSet[1])){
                if(count($arrSet[1]) > 0){
                    foreach($arrSet[1] as $idx => $http_header){
                        $header .= chr(10).$http_header;
                        if($htmlSource == null){
                            $htmlSource = str_replace($http_header, '', $htmlSource);
                        }else{
                            $htmlSource = str_replace($http_header, '', $htmlSource);
                        }
                    }
                }
            }
        }

        curl_close($cURL);

        return $htmlSource;
    }
}

?>
