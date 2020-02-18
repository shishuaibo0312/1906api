<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;
use Illuminate\Support\Facades\Redis;
class GoodsController extends Controller
{
    //商品页面的访问量
     	function goods(){


     		// $goodsinfo=GoodsModel::orderBy('id', 'desc')->limit(10)->get()->toArray();
     		// //dd($datainfo);
     		// $datanumber=count($goodsinfo);
     		// //dd($datanumber);
     		// if($datanumber>=10){
     		// //dd($datainfo);
     		// $datafirst=$goodsinfo[count($goodsinfo)-1];
     		// $time=time()-strtotime($datafirst['created_at']);
     		// //dump($time);
     		// if($time<28860){
     		//  	//dd($time);
     		//  	echo "1分钟内访问不能大于10次";die;
     		// }

     		// }
     		
     
     		//Redis防盗刷
     		$url=substr(md5($_SERVER['REQUEST_URI']),5,8);
     		echo $url;
     		echo "<br>";

     		$ua=substr(md5($_SERVER['HTTP_USER_AGENT']),5,8);
     		echo $ua;
     		echo "<br>";

     		$key='url:ua'.$url.':'.$ua;
     		echo $key;
     		$count=Redis::get($key)+1;
     		dump($count);
     		$max=10;
     		if($count>=$max){
     			Redis::expire($key,10);	
     			echo "请不要频繁刷新页面";
     			dd($count);
     		}
     		Redis::incr($key);die;
     		
     		
     		
     		



     		$goods_name='联想电脑';
     		echo "商品名称:".$goods_name;
     		echo "<br>";

     		$uv=$_SERVER['HTTP_USER_AGENT'];
     		

     		$ip=$_SERVER['REMOTE_ADDR'];
     		//echo "ip:".$ip;
     		
     		   		
     		//存入数据库
 			$data['ip']=$ip;
     		$data['goods_name']=$goods_name;
     		$data['uv']=$uv;
     		GoodsModel::insert($data);
     		
     		$count=GoodsModel::count();
     		echo "访问量pv：".$count;
     		
     		
     		
 			echo "<br>";

 			$info=GoodsModel::get()->toArray();
     		$uvinfo=array_column($info, 'uv');
     		$uvinfo=array_unique($uvinfo);
     		//dd($uvinfo);
     		$uvcount=count($uvinfo);
     		echo "uv:".$uvcount;
     			
     	}


     	function goods2(){
     		//Redis防盗刷
     		// $url=substr(md5($_SERVER['REQUEST_URI']),5,8);
     		// echo $url;
     		// echo "<br>";

     		// $ua=substr(md5($_SERVER['HTTP_USER_AGENT']),5,8);
     		// echo $ua;
     		// echo "<br>";

     		// $key='url:ua'.$url.':'.$ua;
     		// echo $key;
     		// $count=Redis::get($key)+1;
     		// dump($count);
     		// $max=10;
     		// if($count>=$max){
     		// 	Redis::expire($key,10);	
     		// 	echo "请不要频繁刷新页面";
     		// 	dd($count);
     		// }
     		// Redis::incr($key);

     	}
     	function goods3(){
     		
     	}

}
