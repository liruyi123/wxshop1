<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table border="1">
    <tr>
        <td>名称：</td>
        <td>库存：</td>
        <td>价格：</td>
    </tr>
    @foreach($data as $v)
    <tr>
        <td>{{$v->goods_name}}</td>
        <td>{{$v->goods_num}}</td>
        <td>{{$v->self_price}}</td>
    </tr>
        @endforeach
</table>
{{$data->links()}}
</body>
</html>