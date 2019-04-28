@extends('ments')
@section('title')
    购物车
    @endsection
@section('content')
    <body id="loadingPicBlock" class="g-acc-bg">
    <input name="hidUserID" type="hidden" id="hidUserID" value="-1" />
    <div>
        <!--首页头部-->
        <div class="m-block-header">
            <a href="/" class="m-public-icon m-1yyg-icon"></a>
            <a href="/" class="m-index-icon">编辑</a>
        </div>
        <!--首页头部 end-->
        <div class="g-Cart-list">
            <ul id="cartBody">
                @foreach($data as $v)
                <li goods_id="{{$v->goods_id}}" num="{{$v->goods_num}}" cart_id="{{$v->cart_id}}" class="li">
                    <s class="xuan current"></s>
                    <a class="fl u-Cart-img" href="/v44/product/12501977.do">
                        <img src="http://www.upload.com/{{$v->goods_img}}" border="0" alt="">
                    </a>
                    <div class="u-Cart-r">
                        <a href="{{url('goods/shopcontent')}}/{{$v->goods_id}}" class="gray6">{{$v->goods_name}}</a>
                        <span class="gray9">
                            <em>剩余{{$v->goods_num}}</em>
                        </span>
                        <div class="num-opt">
                            <em class="num-mius dis min"><i></i></em>
                            <input class="text_box" name="num" maxlength="6" type="text" value="{{$v->buy_number}}" self="{{$v->self_price}}" codeid="12501977">
                            <em class="num-add add"><i></i></em>
                        </div>
                        <a href="javascript:;" name="delLink" cid="12501977" isover="0" class="z-del"><s></s></a>
                    </div>
                </li>
                @endforeach
            </ul>
                <div id="divNone" class="empty "  style="display: none">
                    <s></s>
                    <p>您的购物车还是空的哦~</p>
                    <a href="https://m.1yyg.com" class="orangeBtn">立即潮购</a>
                </div>
        </div>
        <div id="mycartpay" class="g-Total-bt g-car-new" style="">
            <dl>
                <dt class="gray6">
                    <s class="quanxuan current"></s>全选
                    <p class="money-total">合计<em class="orange total"><span>￥</span>17.00</em></p>

                </dt>
                <dd>
                    <a href="javascript:;" id="a_del" class="orangeBtn w_account remove">删除</a>
                    <a href="javascript:;" id="a_payment" class="orangeBtn w_account">去结算</a>
                </dd>
            </dl>
        </div>
        <div class="hot-recom">
            <div class="title thin-bor-top gray6">
                <span><b class="z-set"></b>人气推荐</span>
                <em></em>
            </div>
            <div class="goods-wrap thin-bor-top">
                <ul class="goods-list clearfix">
                    <li>
                        <a href="https://m.1yyg.com/v44/products/23458.do" class="g-pic">
                            <img src="https://img.1yyg.net/goodspic/pic-200-200/20160908092215288.jpg" width="136" height="136">
                        </a>
                        <p class="g-name">
                            <a href="https://m.1yyg.com/v44/products/23458.do">(第<i>368671</i>潮)苹果（Apple）iPhone 7 Plus 128G版 4G手机</a>
                        </p>
                        <ins class="gray9">价值:￥7130</ins>
                        <div class="btn-wrap">
                            <div class="Progress-bar">
                                <p class="u-progress">
                                    <span class="pgbar" style="width:1%;">
                                        <span class="pging"></span>
                                    </span>
                                </p>
                            </div>
                            <div class="gRate" data-productid="23458">
                                <a href="javascript:;"><s></s></a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="" class="g-pic">
                            <img src="https://img.1yyg.net/goodspic/pic-200-200/20160908092215288.jpg" width="136" height="136">
                        </a>
                        <p class="g-name">
                            <a href="https://m.1yyg.com/v44/products/23458.do">(第368671潮)苹果（Apple）iPhone 7 Plus 128G版 4G手机</a>
                        </p>
                        <ins class="gray9">价值:￥7130</ins>
                        <div class="btn-wrap">
                            <div class="Progress-bar">
                                <p class="u-progress">
                                    <span class="pgbar" style="width:45%;">
                                        <span class="pging"></span>
                                    </span>
                                </p>
                            </div>
                            <div class="gRate" data-productid="23458">
                                <a href="javascript:;"><s></s></a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="https://m.1yyg.com/v44/products/23458.do" class="g-pic">
                            <img src="https://img.1yyg.net/goodspic/pic-200-200/20160908092215288.jpg" width="136" height="136">
                        </a>
                        <p class="g-name">
                            <a href="https://m.1yyg.com/v44/products/23458.do">(第<i>368671</i>潮)苹果（Apple）iPhone 7 Plus 128G版 4G手机</a>
                        </p>
                        <ins class="gray9">价值:￥7130</ins>
                        <div class="btn-wrap">
                            <div class="Progress-bar">
                                <p class="u-progress">
                                    <span class="pgbar" style="width:1%;">
                                        <span class="pging"></span>
                                    </span>
                                </p>
                            </div>
                            <div class="gRate" data-productid="23458">
                                <a href="javascript:;"><s></s></a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="https://m.1yyg.com/v44/products/23458.do" class="g-pic">
                            <img src="https://img.1yyg.net/goodspic/pic-200-200/20160908092215288.jpg" width="136" height="136">
                        </a>
                        <p class="g-name">
                            <a href="https://m.1yyg.com/v44/products/23458.do">(第368671潮)苹果（Apple）iPhone 7 Plus 128G版 4G手机</a>
                        </p>
                        <ins class="gray9">价值:￥7130</ins>
                        <div class="btn-wrap">
                            <div class="Progress-bar">
                                <p class="u-progress">
                                    <span class="pgbar" style="width:1%;">
                                        <span class="pging"></span>
                                    </span>
                                </p>
                            </div>
                            <div class="gRate" data-productid="23458">
                                <a href="javascript:;"><s></s></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        @extends('public.shop')
        </div>
    </body>
    @endsection
@section('my-js')
    <script>
        //下导航显示颜色
        $("#btnCart").addClass('hover');
        $("#btnCart").parent('li').siblings('li').children('a').removeClass('hover');
    </script>
    <!---商品加减算总数---->
    <script type="text/javascript">
        $(function () {
            //点击加号
            $(".add").click(function () {
                // var _is=$(this);
                // console.log(_is.parents('li').attr('num'));
                CartBuyNum(1,$(this));
            })
            //点击减号
            $(".min").click(function () {
                CartBuyNum(2,$(this));
            })
            //失去焦点
            $(".text_box").blur(function(){
                CartBuyNum(3,$(this));
            })
            //点击删除
            $(".z-del").click(function(){
                var _this=$(this);
                var goods_id=_this.parents('li').attr('goods_id');
                layer.confirm('确认删除所有选中的么', {icon: 3, title:'提示'}, function(index){
                    $.ajax({
                        type:'post',
                        url:"{{url('cart/cartDel')}}",
                        data:{goods_id:goods_id,_token: '{{csrf_token()}}'},
                        async:false,
                        success:function(res){
                            layer.msg(res.msg,{icon:res.code});
                            history.go(0);
                        }
                    })
                    layer.close(index);
                })
            })
            //批量删除
            $("#a_del").click(function(){
                var xuan=$(".xuan");
                var goods_id='';
                xuan.each(function(index){
                    //console.log($(this).length);
                    if($(this).hasClass('current')){
                        for(var i=0;i<$(this).length;i++){
                            goods_id+=$(this).parent('li').attr('goods_id')+',';
                        }
                    }
                });
                layer.confirm('确认删除所有选中的么', {icon: 3, title:'提示'}, function(index){
                    $.ajax({
                        type:'post',
                        url:"{{url('cart/delete')}}",
                        data:{goods_id:goods_id,_token:'{{csrf_token()}}'},
                        async:false,
                        success:function(res){
                            layer.msg(res.msg,{icon:res.code});
                            history.go(0);
                        }
                    })
                    layer.close(index);
                })
            })
            //点击结算
            $("#a_payment").click(function(){
                var goods_id='';
                var xuan=$(".xuan");
                xuan.each(function(index){
                    if($(this).hasClass('current')){
                        goods_id+=$(this).parent('li').attr('goods_id')+',';
                    }
                })
                layer.confirm('确认结算？', {
                    btn: ['确认', '取消'] //可以无限个按钮
                    ,btn3: function(index, layero){
                        //按钮【按钮三】的回调
                    }
                }, function(index) {
                    $.ajax({
                        type:'post',
                        url:"{{url('/order/submitOrder')}}",
                        data:{goods_id:goods_id,_token:'{{csrf_token()}}'},
                        async:false,
                        success:function(res){
                            if(res.code==1){
                                location.href="{{url('/cart/payment')}}/"+res.msg;
                            }
                        }
                    })
                })
                {{--layer.confirm('确认去结算？', {icon: 3, title:'提示'}, function(index){--}}
                    {{--$.ajax({--}}
                        {{--type:'post',--}}
                        {{--url:"{{url('cart/payment')}}",--}}
                        {{--data:{goods_id:goods_id,_token:'{{csrf_token()}}'},--}}
                        {{--async:false,--}}
                        {{--success:function(res){--}}
                            {{--console.log(res);--}}
                        {{--}--}}
                    {{--})--}}
                    {{--layer.close(index);--}}
                {{--})--}}
            })
        })
        function CartBuyNum(type,_is){
            var goods_num=_is.parents('li').attr('num');
            var goods_id=_is.parents('li').attr('goods_id');
            var buynum=1;
            var res='';
            //加
            if(type==1){
                res=1;
                var buynum=parseInt(_is.prev().val());
                if(buynum>=goods_num){
                    _is.prop('disabled', true);
                }else{
                    buynum+=1;
                    _is.prev().val(buynum);
                    _is.siblings("input[class='car_btn_1']").prop('disabled',false);
                }
            }else if(type==2){
                var buynum=parseInt(_is.next().val());
                if(buynum<=1){
                    _is.prop('disabled',true);
                }else{
                   buynum-=1;
                   _is.next().val(buynum);
                   _is.siblings("input[class='car_btn_1']").prop('disabled',false);
                }
            }else if(type==3){
                var buynum=parseInt(_is.next().val());
                if(buynum>=goods_num){
                    _is.val(1);
                }else if(buynum>1){
                    _is.val(1);
                }
                buynum=_is.val();
            }
            $.post(
                "{{url('cart/cartBuyNum')}}",
                {goods_id:goods_id,buynum:buynum,res:res,_token:'{{csrf_token()}}'},
                function(res){
                    GetCount();
                }
            )
        }
    </script>
    <script>
        // 全选
        $(".quanxuan").click(function () {
            if($(this).hasClass('current')){
                $(this).removeClass('current');

                $(".g-Cart-list .xuan").each(function () {
                    if ($(this).hasClass("current")) {
                        $(this).removeClass("current");
                    } else {
                        $(this).addClass("current");
                    }
                });
                GetCount();
            }else{
                $(this).addClass('current');

                $(".g-Cart-list .xuan").each(function () {
                    $(this).addClass("current");
                    // $(this).next().css({ "background-color": "#3366cc", "color": "#ffffff" });
                });
                GetCount();
            }


        });
        // 单选
        $(".g-Cart-list .xuan").click(function () {
            if($(this).hasClass('current')){


                $(this).removeClass('current');

            }else{
                $(this).addClass('current');
            }
            if($('.g-Cart-list .xuan.current').length==$('#cartBody li').length){
                $('.quanxuan').addClass('current');

            }else{
                $('.quanxuan').removeClass('current');
            }
            // $("#total2").html() = GetCount($(this));
            GetCount();
            //alert(conts);
        });
        // 已选中的总额
        function GetCount() {
            var conts = 0;
            var aa = 0;
            $(".g-Cart-list .xuan").each(function () {
                if ($(this).hasClass("current")) {
                    for (var i = 0; i < $(this).length; i++) {
                        var arr = ($(this).parents('li').find('input.text_box').attr('self'));
                        conts+=parseInt($(this).parents('li').find('input.text_box').val())*arr;
                        // aa += 1;
                    }
                }
            });

            $(".total").html('<span>￥</span>'+(conts).toFixed(2));
        }
        GetCount();
    </script>
    @endsection
