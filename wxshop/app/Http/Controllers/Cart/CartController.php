<?php

namespace App\Http\Controllers\Cart;

use App\Model\Cate;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\Goods;
use App\Model\OrderDetail;
use App\Model\OrderAddress;
use App\Model\Order;
use App\Tools\alipay\wappay\service\AlipayTradeService;
use App\Tools\alipay\wappay\buildermodel\AlipayTradeWapPayContentBuilder;
class CartController extends Controller
{
    //展示页面
    public function shopcart()
    {
        if(session('user_id')){
            $data=Goods::join('cart','goods.goods_id','=','cart.goods_id')->where(['cart.user_id'=>session('user_id'),'cart_status'=>1])->get();
            return view('cart/shopcart',['data'=>$data]);
        }else{
            return ("<script>alert('请先登陆!');location.href='/user/login'</script>");
        }

    }
    //加入购物车
    public function cartNum()
    {
        if(session('user_id')){
            $goods_id=request()->goods_id;
            if(empty($goods_id)){
                return (['code'=>2,'msg'=>'请选择要加入购物车的商品!']);
            }

            $where=[
                'user_id'=>session('user_id'),
                'goods_id'=>$goods_id
            ];
            //检查库存
            $res=Cart::where($where)->first();
            $bun_num=Goods::where(['goods_id'=>$goods_id])->value('goods_num');
            if(($res['buy_number']+1)>=$bun_num){
                $b_num=$bun_num-($res['buy_number']+1);
                return (['code'=>2,'msg'=>"您购买的数量已超过库存, 还可以购买".$bun_num."件!"]);
            }
            if(!empty($res)){
                $num=$res['buy_number']+1;
                $arr=Cart::where($where)->update(['buy_number'=>$num]);
            }else{
                $arr=Cart::insert(['user_id'=>session('user_id'),'goods_id'=>$goods_id,'buy_number'=>1]);
            }
            if($arr){
                return (['code'=>1,'msg'=>'加入购物车成功']);
            }else{
                return (['code'=>2,'msg'=>'加入购物车失败!']);
            }
        }else{
            return (['code'=>2,'msg'=>'请先登陆!']);
        }
    }
    //修改数量
    public function cartBuyNum()
    {
        $goods_id=request()->goods_id;
        $user_id=session('user_id');
        $buynum=request()->buynum;
        $where=[
            'user_id'=>$user_id,
            'goods_id'=>$goods_id
        ];
        $num=Cart::where($where)->value('buy_number');
        $res=$this->checkNum($buynum,$num,$goods_id);
        if($res){
            $arr=Cart::where($where)->first();
            if(!empty($arr)){
                $add=Cart::where($where)->update(['buy_number'=>$buynum]);
            }else{
                $data=[
                    'user_id'=>$user_id,
                    'goods_id'=>$goods_id,
                    'buy_number'=>$buynum
                ];
                $arr=Cart::insert($data);
            }
        }

    }
    //检测库存
    public function checkNum($buynum,$num,$goods_id)
    {
        $where=[
            'goods_id'=>$goods_id
        ];
        $goods_num=Goods::where($where)->value('goods_num');
        if(($buynum+$num)>=$goods_num){
            $n=$goods_num-$num;
            return (['code'=>2,'msg'=>"您购买的数量已超过库存，还可以购买".$n."件"]);
        }else{
            return true;
        }
    }
    //点击删除
    public function cartDel()
    {
        $goods_id=request()->goods_id;
        if(empty($goods_id)){
            return (['code=>2','msg'=>'请选择要删除的商品!']);
        }
        $user_id=session('user_id');
        $res=Cart::where(['goods_id'=>$goods_id,'user_id'=>$user_id])->delete();
        if($res){
            return (['code=>1','msg'=>'删除成功']);
        }else{
            return (['code=>2','msg'=>'删除失败!']);
        }
    }
    //批量删除
    public function delete()
    {
        $goods_id=request()->goods_id;
        $goods_id=explode(',',rtrim($goods_id,','));
        $res=Cart::where(['user_id'=>session('user_id')])
                ->whereIn('goods_id',$goods_id)
                ->update(['cart_status'=>2]);
        if($res){
            return (['code'=>1,'msg'=>'删除成功']);
        }else{
            return (['code'=>2,'msg'=>'删除失败!']);
        }
    }

    public function payment($id)
    {
        if(session('user_id')){
            $data=OrderDetail::where(['order_id'=>$id,'user_id'=>session('user_id')])->get();
            $num=0;
            foreach($data as $v){
                $num+=$v['self_price']*$v['buy_number'];
            }
            return view('cart/payment',compact('data','id','num'));
        }else{
            return (['code'=>2,'msg'=>'请先登录!']);
        }

    }



}
