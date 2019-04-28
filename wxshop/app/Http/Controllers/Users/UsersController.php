<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Model\User;
use Cache;
class UsersController extends Controller
{
    //注册
    public function register()
    {
        return view('users/register');
    }
    //登陆
    public function login()
    {
        return view('/users/login');
    }
    public function loginAdd()
    {
        $data=\request()->post();
        $res=User::where(['user_name'=>$data['user_name']])->first();
        $error_num=$res['error_num'];
        $error_time=$res['error_time'];
        $time=time();
        $user_id=$res['user_id'];
        if($res){
            if($data['user_pwd']==decrypt($res['user_pwd'])){
                if($error_num>=5&&($time-$error_time)<3600){
                    $num=60-ceil(($time-$error_time)/60);
                    return ("<script>alert('该用户已被锁定,$num 分钟后可以登陆!');location.href='/users/login';</script>");
                }
                $update=[
                    'error_num'=>0,
                    'error_time'=>null
                ];
                User::where(['user_id'=>$user_id])->update($update);
                cache(['user_name'.$user_id=>$res['user_name']],60);
                session(['user_id'=>$user_id]);
                return ("<script>alert('登陆成功');location.href='/users/list';</script>");
            }else{
                if($time-$error_time>3600){
                    $update=[
                        'error_num'=>1,
                        'error_time'=>$time
                    ];
                    User::where(['user_id'=>$user_id])->update($update);
                    return ("<script>alert('还有4次机会登陆!');location.href='/users/login';</script>");
                }else{
                    if($error_num>=5){
                        $num=60-ceil(($time-$error_time)/60);
                        return ("<script>alert('该用户已被锁定,$num 分钟后可以登陆!');location.href='/users/login';</script>");
                    }else{
                        $update=[
                            'error_num'=>$error_num+1,
                            'error_time'=>$time
                        ];
                        User::where(['user_id'=>$user_id])->update($update);
                        $num=5-($error_num+1);
                        return ("<script>alert('还有 $num 次机会登陆!');location.href='/users/login';</script>");
                    }
                }
            }
        }else{
            return ("<script>alert('用户名或密码错误!');location.href='/users/login';</script>");
        }
    }

    public function list()
    {
        $user_id=session('user_id');
        $name=cache('user_name'.$user_id);
        return view('/users/list',compact('name'));
    }
    public function registerAdd()
    {
        $data=request()->except('_token');
        $code=session('user_email.code');
        $user_email=session('user_email.email');
        if($data['user_email']!=$user_email){
            return ("<script>alert('邮箱不匹配!');location.href='/users/register';</script>");
        }
        if($data['code']!=$code){
            return ("<script>alert('验证码有误!');location.href='/users/register';</script>");
        }
        unset($data['code']);
        $data['user_pwd']=encrypt($data['user_pwd']);
        $res=User::insert($data);
        if($res){
            return ("<script>alert('注册成功');location.href='/users/login';</script>");
        }else{
            return ("<script>alert('注册失败!');location.href='/users/register';</script>");
        }
    }
    //验证码
    public function emil()
    {
        $email=request()->emil;
        $code=rand(111111,999999);
        $user_email=[
            'code'=>$code,
            'email'=>$email
        ];
        session(['user_email'=>$user_email]);
        $this->sendMail($email,$code);
        echo 1;
    }
    public function sendMail($email,$code)
    {
        Mail::send('users/email',['code'=>$code],function($message)use($email){
            //主题
            $message->subject("私人邮箱");
            $message->to($email);
        });
    }
}
