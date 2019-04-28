<?php

namespace App\Http\Controllers\User;

use App\Model\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use Mail;
use Validator;

class UserController extends Controller
{
    //登陆
    public function login()
    {
        return view('user/login');
    }
    //我的潮购
    public function userpage()
    {
//        session(['user_id'=>null]);
        $res=[];
        if(session('user_id')){
            $res=User::where(['user_id'=>session('user_id')])->first();
        }

        return view('user/userpage',['res'=>$res]);

    }
    //登陆执行
    public function loginAdd(Request $request)
    {
        $data=request()->data;
        if($data['type']==1){
            //手机号登陆
        }else{
            //邮箱登陆
            $res=User::where(['user_email'=>$data['user_email']])->first();
            $user_id=$res['user_id'];
            $error_num=$res['error_num'];
            $error_time=$res['error_time'];
            $time=time();
            if($res){
                if($data['user_pwd']==decrypt($res['user_pwd'])){
                    if($error_num>=3&&($time-$error_time)<3600){
                        $num=60-ceil(($time-$error_time)/60);
                        return (['code'=>2,'msg'=>"该用户已被锁定，".$num ."分钟后可以登陆!"]);
                    }
                    $update=[
                        'error_num'=>0,
                        'error_time'=>null
                    ];
                    User::where(['user_id'=>$user_id])->update($update);
                    session(['user_id'=>$user_id]);
                    return (['code'=>1,'msg'=>"登陆成功"]);
                }else{
                    if($time-$error_time>3600){
                        $update=[
                            'error_num'=>1,
                            'error_time'=>$time
                        ];
                        User::where(['user_id'=>$user_id])->update($update);
                        return (['code'=>2,'msg'=>"密码错误! 您还有2次机会可以登陆!"]);
                    }else{
                        if($error_num>=3){
                            $num=60-ceil(($time-$error_time)/60);
                            return (['code'=>2,'msg'=>"该用户已被锁定，".$num ."分钟后可以登陆!"]);
                        }else{
                            $update=[
                                'error_num'=>$error_num+1,
                                'error_time'=>$time
                            ];
                            User::where(['user_id'=>$user_id])->update($update);
                            $num=3-($error_num+1);
                            return (['code'=>2,'msg'=>"密码错误! 您还有".$num."次机会可以登陆!"]);
                        }
                    }
                }
            }else{
                return (['code'=>2,'msg'=>'邮箱或密码错误!']);
            }

        }
    }
    //手机号注册
    public function register()
    {

        return view('user/register');
    }
    //注册执行
    public function registerAdd()
    {
        $data=request()->data;
        //print_r($data);die;
        $validator=Validator::make($data,[
//                'user_email'=>"required|unique:user",
            'code'     =>"required",
            'user_pwd'     =>"required",
            'pwd1'    =>'required'

        ],[
//                'user_email.required'=>"手机号或邮箱不能为空!",
//                'user_email.unique'  =>"该用户已存在!",
            'code.required'=>'验证码不能为空!',
            'user_pwd.required' =>'密码不能为空!',
            'pwd1.required'=>'确认密码不能为空!',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if (!empty($errors)) {
                foreach ($errors->all() as $v) {
                    echo  json_encode(['code'=>2,'msg'=>$v]);die;
                }
            }
        }
        if(is_numeric($data['user_email'])){
            $user_tel=session("user_tel.user_tel");
            $code=session("user_tel.codes");
            if($data['user_email']!=$user_tel){
                return (['code'=>2,'msg'=>'请输入正确的邮箱或手机号!']);
            }
            if($data['code']!=$code){
                return (['code'=>2,'msg'=>'验证码有误!']);
            }
            if($data['user_pwd']!=$data['pwd1']){
                return (['code'=>2,'msg'=>'两次密码不一致!']);
            }
            $res=User::where('user_tel',$data['user_email'])->first();
            if($res){
                return (['code'=>2,'msg'=>'该用户已存在!']);
            }
            $data['user_pwd']=encrypt($data['user_pwd']);
            $data['user_tel']=$data['user_email'];
            unset($data['pwd1']);
            unset($data['code']);
            unset($data['user_email']);
            $res=User::insert($data);
            if($res){
                return (['code'=>1,'msg'=>'注册成功']);
            }else{
                return (['code'=>2,'msg'=>'注册失败!']);
            }

        }else{
            $user_email=session('user_email.user_email');
            $code=session('user_email.code');
            if($data['user_email']!=$user_email){
                return (['code'=>2,'msg'=>'邮箱或手机号有误!']);
            }
            if($data['code']!=$code){
                return (['code'=>2,'msg'=>'验证码错误!']);
            }
            if($data['user_pwd']!=$data['pwd1']){
                return (['code'=>2,'msg'=>'两次密码不一致!']);
            }
            $res=User::where('user_email',$data['user_email'])->first();
            if($res){
                return (['code'=>2,'msg'=>'该用户已存在!']);
            }
            $data['user_pwd']=encrypt($data['user_pwd']);
            unset($data['pwd1']);
            unset($data['code']);
            $res=User::insert($data);
            if($res){
                return (['code'=>1,'msg'=>'注册成功']);
            }else{
                return (['code'=>2,'msg'=>'注册失败!']);
            }
            //print_r($data);die;
        }

    }
    //唯一性验证
    public function checkname()
    {
        $type=request()->type;
        $user_name=request()->user_name;
        if($type==3){
            $res=User::where('user_tel',$user_name)->first();
        }else{
            $res=User::where('user_email',$user_name)->first();
        }
        if($res){
            return (['code'=>2,'msg'=>'该用户已存在!']);
        }else{
            return (['code'=>1,'msg'=>'可以使用']);
        }
    }

    //获取验证码
    public function code()
    {
        $type=request()->type;
        $user_name=request()->user_name;
        if($type==3){
            //手机号发送验证码
            $code=rand(111111,999999);
            $user_tel=[
                'codes'=>$code,
                'user_tel'=>$user_name
            ];
            session(['user_tel'=>$user_tel]);
            echo $this->Mobile($code,$user_name);
        }else {
            $code=rand(111111,999999);
            $user_email=[
                'code'=>$code,
                'user_email'=>$user_name
            ];
            session(['user_email'=>$user_email]);
            $this->sendMail($user_name,$code);
            //$data = request()->session()->all();
//            print_r($data);die;
            echo 1;
            //邮箱发送验证码

        }
    }

    //手机号发送验证码
    public function Mobile($code,$mobile)
    {
        $host = env("MOBILE_POST");
        $path = env("MOBILE_PATH");
        $method = "POST";
        $appcode = env("MOBILE_CODE");
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "mobile=".$mobile."&param=code:".$code."&tpl_id=TP1711063";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        print_r(curl_exec($curl));
    }
    //邮箱发送验证码
    public function sendMail($email,$arr)
    {
        Mail::send('user/mail',['arr'=>$arr],function($message)use($email){
           //主题
            $message->subject("李如意的私人邮箱");
            $message->to($email);
        });
    }

}
