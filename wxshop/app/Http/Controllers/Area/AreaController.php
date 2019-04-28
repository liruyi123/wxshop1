<?php

namespace App\Http\Controllers\Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Address;
use Illuminate\Support\Facades\DB;
use Memcache;
use Illuminate\Support\Facades\Redis;
class AreaController extends Controller
{
    //地址展示
    public function address()
    {
        if(session('user_id')){
            $data=Address::where(['user_id'=>session('user_id'),'address_status'=>1])->get();
            return view('area/address',compact('data'));
        }else{
            return "<script>alert('请先登陆!');location.href='/user/login'</script>";
        }

    }
    //收货地址默认
    public function defalt()
    {
        //开启事务
        DB::beginTransaction();
        $address_id=request()->address_id;
        $where=[
          'address_id'=>$address_id,
          'user_id'  =>session('user_id')
        ];
        $arr=Address::where(['user_id'=>session('user_id')])->update(['is_default'=>2]);
        $ass=Address::where($where)->update(['is_default'=>1]);
        if($arr!=false&&$ass!=false){
            //事务提交
            DB::commit();
            return  (['msg'=>'设为默认','code'=>1]);
        }else{
            //事务回滚
            DB::rollback();
            return (['msg'=>'失败!','code'=>2]);
        }
    }
    //点击删除
    public function addressDel()
    {
        $address_id=request()->address_id;
        $user_id=session('user_id');
        $res=Address::where(['user_id'=>$user_id,'address_id'=>$address_id])->update(['address_status'=>2]);
        if($res){
            return (['code'=>1,'msg'=>'删除成功']);
        }else{
            return (['code'=>2,'msg'=>'删除失败!']);
        }
    }
    //地址添加
    public function writeaddr()
    {
        if(session('user_id')){
            return view('area/writeaddr');
        }else{
            return "<script>alert('请先登陆!');location.href='/user/login'</script>";
        }

    }
    //地址添加执行
    public function addressAdd()
    {
        $data=request()->data;
        $user_id=session('user_id');
        if(!empty($user_id)) {
            if ($data['is_default'] == 1) {
                $res = Address::where(['user_id' => $user_id])->update(['is_default' => 2]);
                $data['user_id']=$user_id;
                $add = Address::insert($data);
                if ($add) {
                    return (['code' => 1, 'msg' => '添加成功']);
                } else {
                    return (['code' => 2, 'msg' => '添加失败!']);
                }
            } else {
                $data['user_id']=$user_id;
                $add = Address::insert($data);
                if ($add) {
                    return (['code' => 1, 'msg' => '添加成功']);
                } else {
                    return (['code' => 2, 'msg' => '添加失败!']);
                }
            }
        }else{
            return "<script>alert('请先登陆!');location.href='/user/login'</script>";
        }
    }
    //地址修改
    public function addressEdil($id)
    {
        $user_id=session('user_id');
        if(empty($user_id)){
            return "<script>alert('请先登陆!');location.href='/user/login'</script>";
        }else{
            $data=Address::where(['address_id'=>$id,'user_id'=>$user_id])->first();
            return view('/area/addressEdil',compact('data'));
        }
    }
    //地址修改执行
    public function addressEdilAdd()
    {
        $user_id=session('user_id');
        if(empty($user_id)){
            return "<script>alert('请先登陆!');location.href='/user/login'</script>";
        }else{
            $data=request()->data;
            if($data['is_default']==1){
                //开启事务
                DB::beginTransaction();
                $data['user_id']=$user_id;
                $res=Address::where(['user_id'=>$user_id])->update(['is_default'=>2]);
                $arr=Address::where(['user_id'=>$user_id,'address_id'=>$data['address_id']])->update($data);
                if($res!=false&&$arr!=false){
                    DB::commit();
                    return  (['msg'=>'修改成功','code'=>1]);
                }else{
                    DB::rollBack();
                    return  (['msg'=>'修改失败!','code'=>2]);
                }
            }else{
                $data['user_id']=$user_id;
                $arr=Address::where(['user_id'=>$user_id,'address_id'=>$data['address_id']])->update($data);
                if($arr){
                    return  (['msg'=>'修改成功','code'=>1]);
                }else{
                    return  (['msg'=>'修改失败!','code'=>2]);
                }
            }
        }

    }


    public function memcache()
    {
        $data=[
            'name'=>'zhangsan',
            'age' =>'男',
            'sex' =>20
        ];
        $data=serialize($data);
        Redis::set('name','zhangsan');
        Redis::set('data',$data);
        print_r(unserialize(Redis::get('data')));
//        $new=new Memcache();
//        //打开一个memcached服务端连接
//        $new->connect('127.0.0.1',11211);
//        //增加一个条目到缓存服务器
//        $new->add('name','张三');
//        //替换已经存在的元素的值
//        $new->replace('name','李四');
//        //从服务端获取一个元素
//        $res=$new->get('name');
//   m i     //增加一个条目到缓存服务器
//        $new->add('sex',20);
//        // 增加一个元素的值
//        $ass=$new->increment('sex',5);
//        $age=$new->decrement('sex');
//        //获取服务器统计信息
//        $agg=$new->getStats();
//        //获取一个服务器的在线/离线状态
//        $info=$new->getServerStatus ('127.0.0.1',11211);
//        print_r($info) ;
    }
}
