<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\CouponModel;
use App\Model\CdeailModel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CouponController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $uid = Auth::id();  //获取登录用户的UID
//        echo "UID:".$uid;echo '<hr>';
//
//        $user = Auth::user()->toArray();   //获取登录用户的信息
//        echo '<pre>';print_r($user);echo '<pre>';

        $data = [];
        return view('coupon.index',$data);
    }

    public function getCoupon(Request $request)
    {
        $uid = Auth::id();  //获取登录用户的UID
        $user = Auth::user()->toArray();   //获取登录用户的信息


//        $id = intval($_GET['id']);
        $id = $request->input('id');  //get 获取值
        echo 'id:'.$id;
        echo "<hr/>";

        $couponinfo = CouponModel::find($id);
//        var_dump($couponinfo);
//        echo '<pre>';print_r($couponinfo->toArray());echo '<pre>';
        $now = time();
         if($couponinfo){
            //判断有效期
             $expire_at = strtotime($couponinfo->expire_at);
//             echo $expire_at;
//             die;
            if($now<$expire_at){   //有效
                die("活动结束");
            }

            //发券
             $code = Str::random(8);
            $data = [
                'code' => $code ,
                'uid' => Auth::id(),
                'get_time' => $now,
                'expire_at' => $expire_at,
            ];
            $id = CdeailModel::insertGetId($data);
            if($id>0){
                echo "领卷成功：劵码:".$code;
            }




         }
        echo "恭喜领劵成功";
    }

}
