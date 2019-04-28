<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods;
use App\Model\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class GoodsController extends Controller
{
    static $arrCate=[];
    //商品列表
    public function goodslist($id='')
    {
        $search=request()->search;
        if(!empty($id)){
            $this->cateInfo($id);
            $arr=self::$arrCate;
            $data=Goods::orderBy('self_price','desc')->whereIn('cate_id',$arr)->where('goods_name','like',"%$search%")->take(5)->get();
//            print_r($data);die;
        }else{
            $data=Goods::orderBy('self_price','desc')->where('goods_name','like',"%$search%")->take(5)->get();
        }
        //echo 1111;die;
        $cateInfo=Category::where('pid',0)->get();
        return view('goods/goodslist',compact('data','cateInfo','id'));
    }

    public function add()
    {
        $type=request()->type;
        $cate_id=request()->cate_id;
        $search=request()->search;
        return $this->goodsOrder($cate_id,$type,$search);
    }
    //左侧分类
    public function cateInfo($pid)
    {
        $arr=Category::where('pid',$pid)->get();
        if(count($arr)!=0){
            foreach($arr as $v){
                if($v['pid']==$pid){
                    $cate_id=$v->cate_id;
                    $cateInfo=$this->cateInfo($cate_id);
                    self::$arrCate[]=$cateInfo;
                }
            }
        }else{
            return $pid;
        }

    }

    //排序
    public function goodsOrder($cate_id,$type,$search)
    {
        if(!empty($cate_id)){
            $this->cateInfo($cate_id);
            $arr=self::$arrCate;
            $data=Goods::whereIn('cate_id',$arr)->orderBy('self_price',$type)->where('goods_name','like',"%$search%")->take(5)->get();
            if(!empty($arr)){
                return view('goods/add',['data'=>$data]);
            }else{
                return false;
            }
        }else{
            $data=Goods::orderBy('self_price',$type)->where('goods_name','like',"%$search%")->take(5)->get();
            return view('goods/add',['data'=>$data]);
        }
    }
    //商品详情
    public function shopcontent($id)
    {
//        Redis::del('data'.$id);
//        Redis::del('img'.$id);die;
        if(Redis::exists('data'.$id,'img'.$id)){

            echo 1;
            $data=unserialize(Redis::get('data'.$id));
            $goods_img=unserialize(Redis::get('img'.$id));
        }else{
            echo 2;
            $data=Goods::where(['goods_id'=>$id])->first();
            $img=explode('|',rtrim($data['goods_imgs'],'|'));
            $goods_img=[];
            foreach ($img as $k=>$v){
                $goods_img[]=$v;
            }
            Redis::set('data'.$id,(serialize($data)));
            Redis::set('img'.$id,(serialize($goods_img)));
        }

//        print_r($goods_img);
        return view('goods/shopcontent',compact('data','goods_img'));

    }
    public function show()
    {

        $page=request()->page;
        if(Cache::has('data'.$page,'page')){
            echo 1;
            $data=cache('data'.$page);
        }else{
            echo 2;
            $data=Goods::paginate(5);
            cache(['data'.$page=>$data,'page'=>$page],1);
        }

        return view('goods/show',compact('data'));
    }
}
