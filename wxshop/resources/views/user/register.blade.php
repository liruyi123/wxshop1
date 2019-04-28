@extends('ments')
@section('title')
    注册
    @endsection
@section('content')
    <body>
    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header">
        <strong id="m-title">注册</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
    </div>
    <div class="wrapper">
        <input name="hidForward" type="hidden" id="hidForward" />
        <div class="registerCon">
            <ul>
                <li class="accAndPwd">
                    <dl>
                        <s class="phone"></s><input  maxlength="" name="user_name" id="userName" type="text" placeholder="请输入您的用户名" />
                        <span class="clear">x</span>
                    </dl>
                    <dl>
                        <s class="phone"></s><input  maxlength="" name="user_email" id="userMobile" type="text" placeholder="请输入您的手机号码或邮箱" />
                        <span class="clear">x</span>
                    </dl>
                    <dl>
                        <s class="phone"></s>
                        <input id="code" name="code" type="text" style="width:70%;" placeholder="请输入您的验证码"  />
                        <button style="width: 30%;height:45px; float:right; background-color:chartreuse;"id="span_email" disabled="true">获取验证码</button>
                    </dl>
                    <dl>
                        <s class="password"></s>
                        <input class="pwd" maxlength="11" name="user_pwd" id="pwd1" type="password" placeholder="6-16位数字、字母组成"  />
                        <span class="mr clear">x</span>

                    </dl>
                    <dl>
                        <s class="password"></s>
                        <input class="conpwd" maxlength="11" id="pwd2" name="conpwd" type="password" placeholder="请确认密码"  />
                        <span class="mr clear">x</span>

                    </dl>
                    <dl class="a-set">
                        <i class="gou"></i><p>我已阅读并同意《666潮人购购物协议》</p>
                    </dl>

                </li>
                <li>
                    {{--<a href="javascript:;" id="but" >注册</a>--}}
                    <input type="button" id="but" lay-submit lay-filter="telDemo" value="注册" class="orangeBtn loginBtn">
                </li>

            </ul>
        </div>
        <div class="layui-layer-move"></div>
    </div>
    </body>
    @endsection
@section('my-js')
    <script>
        $(function() {
            layui.use(['form', 'layer'], function () {
                var layer = layui.layer;
                var form = layui.form;
                //用户名
                $("#userName").blur(function(){
                    var _this=$(this);
                    if(_this.val()==''||_this.val()=="请输入您的用户名"){
                        layer.msg('请输入您的用户名！',{icon:2});
                        return false;
                    }
                })
                // 手机号失去焦点
                var type = '';
                $('#userMobile').blur(function () {
                    var reg = /^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[06-8])\d{8}$/;//验证手机正则(输入前7位至11位)
                    var arr = /^[1-9]\d{7,10}@qq\.com$/;
                    var that = $(this);

                    if (that.val() == '' || that.val() == "请输入您的手机号或邮箱") {
                        layer.msg('请输入您的手机号或邮箱！',{icon:2});
                        return false;
                    } else if (that.val().length < 11) {
                        layer.msg('您输入的手机号或邮箱长度有误！',{icon:2});
                        return false;
                    }
                    if (that.val().length == 11) {
                            type = isMobil(that.val());
                        } else {
                        type = isEmail(that.val());
                    }
                    if (type == 1 || type == 2) {
                        layer.msg('您输入的手机号不存在或邮箱格式不正确!');
                        return false;
                    }
                    var fals = false;
                    $.ajax({
                        type: "post",
                        url: "{{url('user/checkname')}}",
                        data: {user_name: that.val(), type: type, _token: '{{csrf_token()}}'},
                        async: false,
                        success: function (res) {
                            if (res.code == 2) {
                                layer.msg(res.msg, {icon: res.code});
                                $("#span_email").prop("disabled", true);
                                fals = false;
                            } else {
                                $("#span_email").prop("disabled", false);
                                fals = true;
                            }
                        }
                    })
                    if (fals == false) {
                        return fals;
                    }
                })
                $("#code").blur(function(){
                    var code = $("#code").val();
                    if (code == '') {
                        layer.msg('请输入验证码!', {icon: 2});
                        return false;
                    }
                })
                //获取验证码
                $("#span_email").click(function () {
                        var user_name = $('#userMobile').val();
                        if (user_name == '') {
                            layer.msg("请输入邮箱或手机号");
                            return false;
                        }
                        if (user_name.length == 11) {
                            type = isMobil(user_name);
                        } else {
                        type = isEmail(user_name);
                    }
                    if (type == 1 || type == 2) {
                        layer.msg('您输入的手机号不存在或邮箱格式不正确!');
                        return false;
                    }
                    //秒数倒计时
                    $("#span_email").text(10 + 's 后重新获取');
                    $("#span_email").prop("disabled", true);
                    var _time = setInterval(secondLess, 1000);
                    var fals;
                    $.ajax({
                        type: "post",
                        url: "{{url('user/code')}}",
                        data: {user_name: user_name, type: type, _token: '{{csrf_token()}}'},
                        async: false,
                        dataType: 'json',
                        success: function (res) {
                            // if (res == 1) {
                            if(res.return_code=='00000'){
                                layer.msg("发送成功");
                                fals = true;
                            } else {
                                layer.msg('发送失败!');
                                fals = false;
                            }
                        }
                    })
                    if (fals == false) {
                        return fals;
                    }
                    function secondLess() {
                        var secode = parseInt($("#span_email").text());
                        if (secode == 0) {
                            $("#span_email").text("获取");
                            clearInterval(_time);
                            $("#span_email").prop("disabled", false);
                        } else {
                            var ass = secode - 1;
                            $("#span_email").text(ass + 's 后重新获取');
                            $("#span_email").prop("disabled", true);
                        }
                    }
                });

                // 密码失去焦点
                $('.pwd').blur(function () {
                    reg = /^[0-9a-zA-Z]{6,16}$/;
                    var that = $(this);
                    if (that.val() == "" || that.val() == "6-16位数字或字母组成") {
                        layer.msg('请设置您的密码！');
                        return false;
                    } else if (!reg.test($(".pwd").val())) {
                        layer.msg('请输入6-16位数字或字母组成的密码!');
                        return false;
                    }
                })

                // 重复输入密码失去焦点时
                $('.conpwd').blur(function () {
                    var that = $(this);
                    var pwd1 = $('.pwd').val();
                    var pwd2 = that.val();
                    if (pwd1 != pwd2) {
                        layer.msg('您俩次输入的密码不一致哦！');
                        return false;
                    }
                })
                //校验手机号码
                function isMobil(s) {
                    //var patrn = /^[+]{0,1}(\d){1,3}[ ]?([-]?((\d)|[ ]){1,12})+$/;
                    var patrn = /^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[06-8])\d{8}$/;
                    if (!patrn.test(s)) {
                        return 1;
                    } else {
                        return 3;
                    }

                }

                //验证邮箱格式
                function isEmail(str) {
                    var arr = /^[1-9]\d{7,10}@qq\.com$/;
                    if (!arr.test(str)) {
                        return 2;
                    } else {
                        return 4;
                    }
                }

                $('.registerCon input').bind('keydown', function () {
                    var that = $(this);
                    if (that.val().trim() != "") {

                        that.siblings('span.clear').show();
                        that.siblings('span.clear').click(function () {
                            console.log($(this));

                            that.parents('dl').find('input:visible').val("");
                            $(this).hide();
                        })

                    } else {
                        that.siblings('span.clear').hide();
                    }

                })

                function show() {
                    if ($('.registerCon input').attr('type') == 'password') {
                        $(this).prev().prev().val($("#passwd").val());
                    }
                }

                function hide() {
                    if ($('.registerCon input').attr('type') == 'text') {
                        $(this).prev().prev().val($("#passwd").val());
                    }
                }

                $('.registerCon s').bind({
                    click: function () {
                        if ($(this).hasClass('eye')) {
                            $(this).removeClass('eye').addClass('eyeclose');

                            $(this).prev().prev().prev().val($(this).prev().prev().val());
                            $(this).prev().prev().prev().show();
                            $(this).prev().prev().hide();


                        } else {
                            console.log($(this));
                            $(this).removeClass('eyeclose').addClass('eye');
                            $(this).prev().prev().val($(this).prev().prev().prev().val());
                            $(this).prev().prev().show();
                            $(this).prev().prev().prev().hide();

                        }
                    }
                })
                // 购物协议
                $('dl.a-set i').click(function () {
                    var that = $(this);
                    if (that.hasClass('gou')) {
                        that.removeClass('gou').addClass('none');
                        $('#btnNext').css('background', '#ddd');

                    } else {
                        that.removeClass('none').addClass('gou');
                        $('#btnNext').css('background', '#f22f2f');
                    }

                })

                $("#but").click(function(){
                        var _this=$("#userName");
                        if(_this.val()==''||_this.val()=="请输入您的用户名"){
                            layer.msg('请输入您的用户名！',{icon:2});
                            return false;
                        }
                        // 手机号失去焦点
                        var type = '';
                        var reg = /^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[06-8])\d{8}$/;//验证手机正则(输入前7位至11位)
                        var arr = /^[1-9]\d{7,10}@qq\.com$/;
                        var that = $('#userMobile');
                        if (that.val() == '' || that.val() == "请输入您的手机号或邮箱") {
                            layer.msg('请输入您的手机号或邮箱！');
                            return false;
                        } else if (that.val().length < 11) {
                            layer.msg('您输入的手机号或邮箱长度有误！');
                            return false;
                        }
                        if (that.val().length == 11) {
                            type = isMobil(that.val());
                        } else {
                            type = isEmail(that.val());
                        }
                        if (type == 1 || type == 2) {
                            layer.msg('您输入的手机号不存在或邮箱格式不正确!');
                            return false;
                        }
                        var arr=false;
                        $.ajax({
                            type: "post",
                            url: "{{url('user/checkname')}}",
                            data: {user_name: that.val(), type: type, _token: '{{csrf_token()}}'},
                            async: false,
                            success: function (res) {
                                if (res.code == 2) {
                                    layer.msg(res.msg, {icon: res.code});
                                    $("#span_email").prop("disabled", true);
                                    arr = false;
                                } else {
                                    $("#span_email").prop("disabled", false);
                                    arr=true;
                                }
                            }
                        })
                        if (arr == false) {
                            return arr;
                        }
                        var code = $("#code").val();
                        if (code == '') {
                            layer.msg('请输入验证码!', {icon: 2});
                            return false;
                        }
                        // 密码失去焦点
                        var reg = /^[0-9a-zA-Z]{6,16}$/;
                        var that = $('.pwd');
                        if (that.val() == "" || that.val() == "6-16位数字或字母组成") {
                            layer.msg('请设置您的密码！');
                            return false;
                        } else if (!reg.test($(".pwd").val())) {
                            layer.msg('请输入6-16位数字或字母组成的密码!');
                            return false;
                        }

                        // 重复输入密码失去焦点时
                        var that = $('.conpwd');
                        var pwd1 = $('.pwd').val();
                        var pwd2 = that.val();
                        if (pwd1 != pwd2) {
                            layer.msg('您俩次输入的密码不一致哦！');
                            return false;
                        }
                        var obj={};
                        obj.user_name=$("#userName").val(),
                        obj.user_email=$('#userMobile').val(),
                        obj.code=$("#code").val(),
                        obj.user_pwd=$("#pwd1").val(),
                        obj.pwd1=$("#pwd2").val();
                        $.post(
                            "{{url('user/registerAdd')}}",
                            {_token:'{{csrf_token()}}',data:obj},
                            function(res){
                                layer.msg(res.msg,{inco:res.code,time:3000},function(){
                                    if(res.code==1){
                                        location.href="{{url('user/login')}}";
                                    }
                                });
                            }
                        )
                        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
                    });
            })
        })
    </script>
    @endsection
