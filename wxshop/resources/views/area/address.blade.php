@extends('ments')
@section('title')
    地址管理
    @endsection
@section('content')
    <link rel="stylesheet" href="{{url('css/address.css')}}">
    <link rel="stylesheet" href="{{url('css/sm.css')}}">
    <body>
        <!--触屏版内页头部-->
        <div class="m-block-header" id="div-header">
            <strong id="m-title">地址管理</strong>
            <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
            <a href="/area/writeaddr" class="m-index-icon">添加</a>
        </div>
        <div class="addr-wrapp">
            @foreach($data as $v)
            <div class="addr-list">
                <ul>
                    <li class="clearfix">
                        <span class="fl">{{$v->address_name}}</span>
                        <span class="fr">{{$v->address_tel}}</span>
                    </li>
                    <li>
                        <p>{{$v->address_area}}&nbsp;&nbsp;{{$v->address_mail}}</p>
                    </li>
                    @if($v['is_default']==1)

                    <li class="a-set">
                        <s class="z-set" style="margin-top: 6px;" address_id="{{$v->address_id}}"></s>
                        <span>默认</span>
                        <div class="fr">
                            <span class="edit">编辑</span>
                            <span class="remove">删除</span>
                        </div>
                    </li>
                        @else
                        <li class="a-set">
                            <s class="z-defalt" style="margin-top: 6px;" address_id="{{$v->address_id}}"></s>
                            <span>设为默认</span>
                            <div class="fr">
                                <span class="edit">编辑</span>
                                <span class="remove">删除</span>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
            @endforeach
        </div>
    </body>
    @endsection
@section('my-js')
    <script src="{{url('js/zepto.js')}}" charset="utf-8"></script>
    <script src="{{url('js/sm.js')}}"></script>
    <script src="{{url('js/sm-extend.js')}}"></script>
    <script src="{{url('js/jquery-1.8.3.min.js')}}"></script>
    <!-- 单选 -->
    <script>
        //点击默认
        $(".z-defalt").click(function(){
            var _this=$(this);
            var address_id=_this.attr('address_id');
            $.post(
                "{{url('area/defalt')}}",
                {address_id:address_id,_token:'{{csrf_token()}}'},
                function(res){
                    layer.msg(res.msg,{icon:res.code,time:1000},function(){
                        history.go(0);
                    })
                }
            )

        })
        // 删除地址
        $(document).on('click','span.remove', function () {
            var _this=$(this);
            var address_id=_this.parent().prevAll('s').attr('address_id');
            $.ajax({
                type:'post',
                url:"{{url('area/addressDel')}}",
                data:{address_id:address_id,_token: '{{csrf_token()}}'},
                success:function(res){
                    layer.msg(res.msg,{icon:res.code,time:2000},function(){
                        history.go(0);
                    })
                }
            })
        });
        //点击编辑
        $(document).on('click','span.edit',function(){
            var _this=$(this);
            var address_id=_this.parent().prevAll('s').attr('address_id');
            location.href="{{url('/area/addressEdil')}}/"+address_id;
        })
    </script>
    <script>
        var $$=jQuery.noConflict();
        $$(document).ready(function(){
            // jquery相关代码
            $$('.addr-list .a-set s').toggle(
                function(){
                    if($$(this).hasClass('z-set')){

                    }else{
                        $$(this).removeClass('z-defalt').addClass('z-set');
                        $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                    }
                },
                function(){
                    if($$(this).hasClass('z-defalt')){
                        $$(this).removeClass('z-defalt').addClass('z-set');
                        $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                    }

                }
            )

        });

    </script>
    @endsection
