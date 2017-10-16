<?php
$number = $_POST['From'];
$body = $_POST['Body'];

header('Content-Type: text/xml');


class Translate {
    
    static $Lang = Array (
            'auto' => '自动检测',
            'ara' => '阿拉伯语',
            'de' => '德语',
            'ru' => '俄语',
            'fra' => '法语',
            'kor' => '韩语',
            'nl' => '荷兰语',
            'pt' => '葡萄牙语',
            'jp' => '日语',
            'th' => '泰语',
            'wyw' => '文言文',
            'spa' => '西班牙语',
            'el' => '希腊语',
            'it' => '意大利语',
            'en' => '英语',
            'yue' => '粤语',
            'zh' => '中文' 
    );
  
    static function getLang() {
        return self::$Lang;
    }
   
    static function exec($text, $from = 'auto', $to = 'en') {
        // http://fanyi.baidu.com/v2transapi?from=zh&query=%E7%94%A8%E8%BD%A6%E8%B5%84%E8%AE%AF&to=fra
        $url = "http://fanyi.baidu.com/v2transapi";
        $data = array (
                'from' => $from,
                'to' => $to,
                'query' => $text 
        );
        $data = http_build_query ( $data );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_REFERER, "http://fanyi.baidu.com" );
        curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:37.0) Gecko/20100101 Firefox/37.0' );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        
        $result = json_decode ( $result, true );
        
        if (!isset($result ['trans_result'] ['data'] ['0'] ['dst'])){
            return false; 
        }
        return $result ['trans_result'] ['data'] ['0'] ['dst'];
    }
}
$rep = Translate::exec ( $body );

?>


<Response>
    <Message>
	Hi,"<?php echo $body  ?>" is "<?php echo $rep  ?>" <!--<?php echo $number ?>. -->
    </Message>
</Response>
