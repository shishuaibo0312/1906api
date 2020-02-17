<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;
class GoodsController extends Controller
{
    //商品页面的访问量
     	function goods(){
     		$goods_name='联想电脑';
     		echo "商品名称:".$goods_name;
     		echo "<br>";

     		$uv=$_SERVER['HTTP_USER_AGENT'];
     		//echo "uv:".$uv;
     		echo "<br>";

     		$ip=$_SERVER['REMOTE_ADDR'];
     		//echo "ip:".$ip;
     		
     		
     		//存入数据库
     		$info=GoodsModel::where('uv','=',$uv)->first();
     		//dd($info);
     		if($info){
     			GoodsModel::where('uv','=',$uv)->update(['pv'=>$info['pv']+1]);
     			$pv=$info['pv']+1;
     			echo "访问量：".$pv;
     		}else{
     			$data['ip']=$ip;
	     		$data['goods_name']=$goods_name;
	     		$data['pv']=1;
	     		$data['uv']=$uv;
	     		$data['created_at']=time();
	     		$id=GoodsModel::insertGetId($data);
	     		echo "访问量：".$data['pv'];
     		}
     		
     	}
}
