<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Wechat extends Model
{
    /*
     * @content 发送文本信息内容
     * */
    public static function sendTextMessage($formUserName,$toUserName,$content)
    {
        $time=time();
        $msgtype='text';
        $texttpl="<xml>
              <ToUserName><![CDATA[%s]]></ToUserName>
              <FromUserName><![CDATA[%s]]></FromUserName>
              <CreateTime>%s</CreateTime>
              <MsgType><![CDATA[%s]]></MsgType>
              <Content><![CDATA[%s]]></Content>
            </xml>";
        //拼装xml
        $result=sprintf($texttpl,$formUserName,$toUserName,$time,$msgtype,$content);
        echo $result;
        exit;

    }

    /*
     * @content 发送图片信息
     * */
    public static function sendImageMessage($formUserName,$toUserName,$content)
    {
        $texttpl = "<xml>
                  <ToUserName><![CDATA[toUser]]></ToUserName>
                  <FromUserName><![CDATA[fromUser]]></FromUserName>
                  <CreateTime>12345678</CreateTime>
                  <MsgType><![CDATA[image]]></MsgType>
                  <Image>
                    <MediaId><![CDATA[media_id]]></MediaId>
                  </Image>
                </xml>";
    }
    /*
     * @content 获取access_token
     * */
    public static function GetAccessToken()
    {
//        return Redis::get('token');
        //获取token文件的路径
//        $fileName=Redis::get('text');
        //$fileName=public_path()."/token.text";
        $fileName=Redis::get('token');
        //return $fileName;
        //$str=file_get_contents($fileName);
//        return $str;
        $info=json_decode($fileName,true);
        if($info['expires_in']<time()){
            //过期了
            $token=self::CreateAccessToken();
            $expire=time()+7000;
            $data=['token'=>$token,'expires_in'=>$expire];
            $info=json_encode($data);
           //chmod($fileName,0777);
//            file_put_contents($fileName,$info);
            Redis::set('token',$info);
        }else{
            //没有过期
            $token=$info['token'];
        }
        return $token;
    }
    /*
     * @content 生成token
     * */
    public static function CreateAccessToken()
    {
        $appid=env("WXAPPID");
        $appsecret=env("WXAPPSECRET");
        $token_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        //发起get请求
        //Redis::set(['access_token'])
        $re=file_get_contents($token_url);
        Redis::set('token',$re);
//        print_r($re);die;
        $token=json_decode($re,true)['access_token'];
        return $token;
    }
    /*
     * @content 图灵机器人
     * */
    public static function tuling($keywords)
    {
        //图灵机器人调用url
        $url="http://openapi.tuling123.com/openapi/api/v2";
        //拼接参数
        $postdata=[
            "reqType"=>0,
            "perception"=>[
                "inputText"=>[
                "text"=>$keywords
                ]
            ],
            "userInfo"=>[
                "apiKey"=>"aa48b6e6d03943849b2e318d6fede176",
                "userId"=>"aa48b6e6d03943849b2e318d6fede176"
            ]
        ];
        //将参数转为json格式
        $postjson=json_encode($postdata,JSON_UNESCAPED_UNICODE);
        //post方式提交数据到指定的url
        $res=self::HttpPost($url,$postjson);
        //将返回值转为数组
        $data=json_decode($res,true);
//        dd($data);
//        return $data;
        return $data['results'][0]['values']['text'];
    }
    /*
     * @content post方式提交
     * */
    public static function HttpPost($url,$post_data)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL,$url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $data;
    }

}
