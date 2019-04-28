@extends('ments')
@section('title')
    登陆
    @endsection
@section('content')
    <body>
        <!--触屏版内页头部-->
        <div class="m-block-header" id="div-header">
            <strong id="m-title">登录</strong>
            <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
            <a href="/" class="m-index-icon"><i class="home-icon"></i></a>
        </div>
        <form action="{{url('user/loginAdd')}}" method="post">
        <div class="wrapper">
            <div class="registerCon">
                <div class="binSuccess5">
                    <ul>
                        <li class="accAndPwd">
                            <dl>
                                <div class="txtAccount">
                                    <input id="user_name" type="text" name="user_name" placeholder="请输入您的手机号码/邮箱"><i></i>
                                </div>
                                <cite class="passport_set" style="display: none"></cite>
                            </dl>
                            <dl>
                                <input id="pwd" type="password" name="user_pwd" placeholder="密码"maxlength="20" /><b></b>
                            </dl>
                        </li>
                    </ul>
                    <a id="btnLogin" href="javascript:;" class="orangeBtn loginBtn">登录</a>
                </div>
                <div class="forget">
                    <a href="https://m.1yyg.com/v44/passport/FindPassword.do">忘记密码？</a><b></b><a href="{{url('user/register')}}">新用户注册</a>
                </div>
            </div>
            <div class="oter_operation gray9" style="display: none;">

                <p>登录666潮人购账号后，可在微信进行以下操作：</p>
                1、查看您的潮购记录、获得商品信息、余额等<br />
                2、随时掌握最新晒单、最新揭晓动态信息
            </div>
        </div>
        </form>
        <div class="footer clearfix" style="display:none;">
            <ul>
                <li class="f_home"><a href="/v44/index.do" ><i></i>潮购</a></li>
                <li class="f_announced"><a href="/v44/lottery/" ><i></i>最新揭晓</a></li>
                <li class="f_single"><a href="/v44/post/index.do" ><i></i>晒单</a></li>
                <li class="f_car"><a id="btnCart" href="/v44/mycart/index.do" ><i></i>购物车</a></li>
                <li class="f_personal"><a href="/v44/member/index.do" ><i></i>我的潮购</a></li>
            </ul>
        </div>
    </body>
    @endsection
@section('my-js')
    <script>
        $(function(){
            $("#user_name").blur(function(){
                var _this=$(this);
                var reg = new RegExp (/(^[\w.\-]+@(?:[a-z0-9]+(?:-[a-z0-9]+)*\.)+[a-z]{2,3}$)|(^1[3|4|5|7|8]\d{9}$)/);
                if(_this.val()==''||_this.val()=="请输入您的手机号码/邮箱"){
                    layer.msg("请输入您的手机号码/邮箱",{icon:2});
                    return false;
                }
                if(!reg.test(_this.val())){
                    layer.msg("格式不正确,请输入正确的!",{icon:2});
                    return false;
                }
                var type='';
                if(_this.val().length==11){
                    type=1;
                }else{
                    type=2;
                }

            })
            $("#pwd").blur(function(){
                var _this=$(this);
                if(_this.val()==''||_this.val()=="密码"){
                    layer.msg("请输入密码!",{icon:2});
                    return false;
                }
            })
            $("#btnLogin").click(function(){
                    var _this=$("#user_name");
                    var reg = new RegExp (/(^[\w.\-]+@(?:[a-z0-9]+(?:-[a-z0-9]+)*\.)+[a-z]{2,3}$)|(^1[3|4|5|7|8]\d{9}$)/);
                    if(_this.val()==''||_this.val()=="请输入您的手机号码/邮箱"){
                        layer.msg("请输入您的手机号码/邮箱",{icon:2});
                        return false;
                    }
                    if(!reg.test(_this.val())){
                        layer.msg("格式不正确,请输入正确的!",{icon:2});
                        return false;
                    }
                    var type='';
                    if(_this.val().length==11){
                        type=1;
                    }else{
                        type=2;
                    }
                    var _this=$("#pwd")
                    if(_this.val()==''||_this.val()=="密码"){
                        layer.msg("请输入密码!",{icon:2});
                        return false;
                    }
                    var obj={};
                        obj.user_email=$("#user_name").val(),
                        obj.user_pwd=$("#pwd").val(),
                        obj.type=type;
                    $.post(
                        "{{url('user/loginAdd')}}",
                        {data:obj,_token:'{{csrf_token()}}'},
                        function(res){
                            layer.msg(res.msg,{icon:res.code,time:2000},function(){
                                if(res.code==1){
                                    location.href="{{url('/')}}";
                                }
                            })
                        }
                    )
            })
        })
    </script>
    @endsection
