<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods;
use Illuminate\Support\Facades\DB;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Address;
use App\Model\OrderAddress;
class OrderController extends Controller
{
    //点击结算
    public function submitOrder()
    {
        if(!session('user_id')){
            return (['code'=>2,'msg'=>'请先登录!']);
        }
        $goods_id=request()->goods_id;
        if(empty($goods_id)){
            return (['code'=>2,'msg'=>'请选择要购买的商品!']);
        }
        //开启事务
        //DB::beginTransaction();
        $orderInfo['order_no']=$this->OrderOn();
        $orderInfo['user_id']=session('user_id');
        $orderInfo['order_amount']=$this->buyNum($goods_id);
        $arr=Order::insertGetId($orderInfo);
        $goodsInfo=$this->goodsInfo($goods_id);
        foreach($goodsInfo as $k=>$v) {
            $num = $this->checkNum($goods_id, 0, $v['buy_number']);
            if (empty($num)) {
                return (['code' => 2, 'msg' => $v['goods_name'] . '库存不足，请选择其他商品!']);
            }
            $goodsInfo[$k]['order_id'] = $arr;
            $goodsInfo[$k]['user_id'] = session('user_id');

        }
        $arr1=DB::table('order_detail')->insert($goodsInfo);
        if(!$arr1){
            return (['code'=>2,'msg'=>'商品详情有误!']);
        }
        $arr2=Address::where(['is_default'=>1,'user_id'=>session('user_id')])->first(['address_name','address_tel','address_mail','address_area'])->toArray();
        if($arr2){
            $arr2['user_id']=session('user_id');
            $arr2['order_id']=$arr;
            $res=OrderAddress::insert($arr2);
            if($res){
                return (['code'=>1,'msg'=>$arr]);
            }
        }else{
            return (['code'=>2,'msg'=>'地址有误请查看!']);
        }

    }
    //获取商品
    public function goodsInfo($goods_id)
    {
        $goods_id=explode(',',rtrim($goods_id,','));
            $res=Goods::join('cart','goods.goods_id','=','cart.goods_id')
                ->where(['cart.user_id'=>session('user_id')])
                ->whereIn('goods.goods_id',$goods_id)
                ->get(['goods.goods_id','goods_name','buy_number','goods_img','self_price'])->toArray();
            return $res;
    }
    //获取总价
    public function buyNum($goods_id)
    {
        $goods_id=explode(',',rtrim($goods_id,','));
        $res=Goods::join('cart','goods.goods_id','=','cart.goods_id')
            ->where(['cart.user_id'=>session('user_id')])
            ->whereIn('goods.goods_id',$goods_id)
            ->get();
        $price=0;
        if(empty($res)){
            return (['code'=>2,'msg'=>'请选择要购买的商品!']);
        }else{
            //获取总价
            foreach($res as $k=>$v){
                $price +=$v['self_price']*$v['buy_number'];
            }
        }
        return $price;
    }
    //检测库存
    public function checkNum($goods_id,$num,$buy_number)
    {
        $where=[
            'goods_id'=>$goods_id
        ];
        $goods_num=Goods::where($where)->value('goods_num');
        if(($num+$buy_number)>$goods_num){
            $m=$goods_num-$num;
            return (['code'=>2,'msg'=>"您购买的数量已超过库存，还可以购买". $m ."件"]);
        }else{
            return true;
        }
    }
    //订单号
    public function OrderOn()
    {
        //订单规则  当前时间+四位随机数
        return time().rand(1111,9999);
    }
}
