<?php
namespace WeiXin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){  
        $code = I("code");
        $url_token = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx8aee9269c51fc437&secret=d4624c36b6795d1d99dcf0547af5443d&code=".$code."&grant_type=authorization_code";
        $json = $this->reqdata($url_token);
        //微信后台获取APPID和secret填入，获取微信微信用户openid
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
            if(I('param')) {
                redirect('/Admin/Login');
            } else {
                redirect('/User/Login');
            }
        }
    }

    function login() {
        //snsapi_userinfo方式获取微信用户openid
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx8aee9269c51fc437&redirect_uri=http%3a%2f%2fhiqiqi.tunnel.2bdata.com%2fWeiXin%2fIndex&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        redirect($url);
    }

    //验证接口配置
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

    //解析json
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