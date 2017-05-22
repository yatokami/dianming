<?php
namespace WinXin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){  
        $code = I("code");
        $url_token = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxee3a45e8e3870253&secret=e465ae2ebb51479ec659c86fb8387483&code=".$code."&grant_type=authorization_code";
        $json = $this->reqdata($url_token);
        if($json["openid"] != null) {
            $data["openid"] = $json["openid"];
            $data["access_token"] = $json["access_token"];
            $data["refresh_token"] = $json["refresh_token"];
            $data["scope"] = $json["scope"];

            $weixin = M('weixin_cache');
            $map["openid"] = $json["openid"];
            $count = $weixin->where($map)->count();
            if($count == 0) {
                $weixin->add($data);
            }
            session('openid', $json["openid"]);
            redirect('/User/Login');
        }
    }

    function login() {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxee3a45e8e3870253&redirect_uri=http%3a%2f%2fwww.xsenser.com%2fWinXin%2fIndex&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        redirect($url);
    }


    public function checksignature() {
        $signature = $_GET['signature']; //微信加密签名
        $timestamp = $_GET['timestamp']; //时间戳
        $nonce = $_GET['nonce']; //随机数
        $echostr = $_GET['echostr']; //随机字符串
        $token = "weixinphp";
        $tempArr = array($token,$timestamp,$nonce);
        sort($tempArr);
        if($signature ==sha1(implode($tempArr))){
            echo $echostr;
        }else{
            exit();
        }
    }

    public function reqdata($url_token) {
        $html = $this->http($url_token);
        if($html[0] == 200)
        {
            return json_decode($html[1], TRUE);
        }
        else{
            return FALSE;
        }
    }

    public function http($url, $method, $postfields = null, $headers = array(), $debug = false)
    {
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);

        switch ($method) {
        case 'POST':
        curl_setopt($ci, CURLOPT_POST, true);
        if (!empty($postfields)) {
        curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
        $this->postdata = $postfields;
        }
        break;
        }
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);

        $response = curl_exec($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);

        if ($debug) {
        echo "=====post data======\r\n";
        var_dump($postfields);

        echo '=====info=====' . "\r\n";
        print_r(curl_getinfo($ci));

        echo '=====$response=====' . "\r\n";
        print_r($response);
        }
        curl_close($ci);
        return array($http_code, $response);
    }

}