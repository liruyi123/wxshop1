<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
</head>
<body>
<form action="{{url('/users/registerAdd')}}" method="post">
    @csrf
    <table border="1">
        <tr>
            <td>用户名：</td>
            <td><input type="text" name="user_name" id=""></td>
        </tr>
        <tr>
            <td>邮箱：</td>
            <td><input type="text" name="user_email" id="emil"></td>
        </tr>
        <tr>
            <td><button id="but">获取</button></td>
            <td><input type="text" name="code" id=""></td>
        </tr>
        <tr>
            <td>密码：</td>
            <td><input type="password" name="user_pwd" id=""></td>
        </tr>
        <tr>
            <td>确认密码:</td>
            <td><input type="password" name="pwd" id=""></td>
        </tr>
        <tr>
            <td></td>
            <td><button id="but1">注册</button></td>
        </tr>
    </table>
</form>
</body>
</html>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script>
    $("#but").click(function(){
        var emil=$("#emil").val();
        if(emil==''){
            alert('请输入邮箱!');
            return false;
        }
        var fals=false;
        $.ajax({
            type:"post",
            url:"{{url('users/emil')}}",
            data:{emil:emil,_token:'{{csrf_token()}}'},
            async:false,
            success:function(res){
                if(res==1){
                    alert('发送成功!');
                    fals=false;
                }
            }
        })
        if(fals==false){
            return false;
        }
    })
    $("#but1").click(function(){
        var name=$("input[name='user_name']").val();
        var emil=$("input[name='user_email']").val();
        var pwd=$("input[name='user_pwd']").val();
        var pwd1=$("input[name='pwd']").val();
        var code=$("input[name='code']").val();
        if(name==''||emil==''||pwd==''||code==''||pwd1==''){
            return false;
        }
        if(pwd!=pwd1){
            return false;
        }
        $('form').submit();
    })
</script>