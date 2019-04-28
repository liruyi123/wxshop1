@extends('ments')
@section('title')
    修改收货地址
    @endsection
<link rel="stylesheet" href="{{url('css/writeaddr.css')}}">
<link rel="stylesheet" href="{{url('dist/css/LArea.css')}}">
@section('content')
    <body>
    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header">
        <strong id="m-title">修改收货地址</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="javascript:;" id="add" class="m-index-icon">保存</a>
    </div>
    <div class=""></div>
    <!-- <form class="layui-form" action="">
  <input type="checkbox" name="xxx" lay-skin="switch">
    </body>
    </form> -->
    <form class="layui-form" action="">
        <div class="addrcon">
            <input type="hidden"  name="address_id" value="{{$data->address_id}}" id="">
            <ul>
                <li><em>收货人</em><input type="text" name="address_name" value="{{$data->address_name}}" placeholder="请填写真实姓名"></li>
                <li><em>手机号码</em><input type="number" name="address_tel" value="{{$data->address_tel}}" placeholder="请输入手机号"></li>
                <li><em>所在区域</em><input type="text" name="address_area" value="{{$data->address_area}}" placeholder="请选择所在区域"></li>
                <li class="addr-detail"><em>详细地址</em><input type="text" name="address_mail" value="{{$data->address_mail}}" placeholder="20个字以内" class="addr"></li>
            </ul>
            <div class="setnormal"><span>设为默认地址</span>
                <input type="checkbox" @if($data['is_default']==1)checked @endif id="box" name="xxx" lay-skin="switch">
            </div>

        </div>
    </form>
    @endsection
@section('my-js')

    <script>
        //Demo
        layui.use('form', function(){
            var form = layui.form();
            $("#add").click(function(){
                var address_name=$("input[name='address_name']").val();
                if(address_name==''){
                    layer.msg('请填写收货人姓名!',{icon:2});
                    return false;
                }
                var reg = /^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[06-8])\d{8}$/;
                var address_tel=$("input[name='address_tel']").val();
                if(address_tel==''){
                    layer.msg('请填写收货人手机号!',{icon:2});
                    return false;
                }
                if()
                var address_area=$("input[name='address_area']").val();
                if(address_area==''){
                    layer.msg('请填写收货人所在区域!',{icon:2});
                    return false;
                }
                var address_mail=$("input[name='address_mail']").val();
                if(address_area==''){
                    layer.msg('请填写收货人详细地址!',{icon:2});
                    return false;
                }
                var box=$("#box").prop('checked');
                var is_default='';
                if(box==true){
                    is_default=1;
                }else{
                    is_default=2;
                }
                var obj={};
                obj.address_name=$("input[name='address_name']").val(),
                    obj.address_tel=$("input[name='address_tel']").val(),
                    obj.address_area=$("input[name='address_area']").val(),
                    obj.address_mail=$("input[name='address_mail']").val(),
                    obj.address_id=$("input[name='address_id']").val(),
                    obj.is_default=is_default;
                $.post(
                    "{{url('area/addressEdilAdd')}}",
                    {data:obj,_token:'{{csrf_token()}}'},
                    function(res){
                        layer.msg(res.msg,{icon:res.code,time:2000},function(){
                            if(res.code==1){
                                location.href="{{url('/area/address')}}";
                            }
                        })
                    }
                )
            })
        });

        var area = new LArea();
        area.init({
            'trigger': '#demo1',//触发选择控件的文本框，同时选择完毕后name属性输出到该位置
            'valueTo':'#value1',//选择完毕后id属性输出到该位置
            'keys':{id:'id',name:'name'},//绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
            'type':1,//数据源类型
            'data':LAreaData//数据源
        });


    </script>
    @endsection
