<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登陆</title>
</head>
<body>
<form action="{{url('/users/loginAdd')}}" method="post">
    @csrf
    <table border="1">
        <tr>
            <td>用户名：</td>
            <td><input type="text" name="user_name" id=""></td>
        </tr>
        <tr>
            <td>密码：</td>
            <td><input type="password" name="user_pwd" id=""></td>
        </tr>
        <tr>
            <td><button id="but">登陆</button></td>
            <td></td>
        </tr>
    </table>
</form>
</body>
</html>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script>
    $("#but").click(function(){
        var name=$("input[name='user_name']").val();
        var pwd=$("input[name='user_pwd']").val();
        if(name==''||pwd==''){
            return false;
        }
        $("form").submit();
    })
</script>