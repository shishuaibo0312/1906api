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


     		$goodsinfo=GoodsModel::orderBy('id', 'desc')->limit(10)->get()->toArray();
     		//dd($datainfo);
     		$datanumber=count($goodsinfo);
     		//dd($datanumber);
     		if($datanumber>=10){
     		//dd($datainfo);
     		$datafirst=$goodsinfo[count($goodsinfo)-1];
     		$time=time()-strtotime($datafirst['created_at']);
     		//dump($time);
     		if($time<28860){
     		 	//dd($time);
     		 	echo "1分钟内访问不能大于10次";die;
     		}

     		}
     		
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
}
