<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Category;
class IndexController extends Controller
{
    //首页
    public function index()
    {
        $data=Goods::where('is_up',1)->get();
        $cateInfo=Category::get();
        $cateInfo=$this->cateInfo($cateInfo);
        return view('index',compact('data','cateInfo'));
    }
    //分类查询
    public function cateInfo($cateInfo,$pid=0)
    {
        static $arr=[];
        foreach($cateInfo as $k=>$v){
            if($v['pid']==$pid){
                $arr[]=$v;
            }
        }
        return $arr;
    }
}
