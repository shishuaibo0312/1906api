<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
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

     //支付宝接口
          function alipay(){
             $client= new Client();
             //沙箱环境
             $url="https://openapi.alipaydev.com/gateway.do";

             //请求参数
             $common_param=[
                 'out_trade_no'  =>'alipay1906_'.time().'_'.mt_rand(11111,99999),    //商户订单号
                 'product_code'  =>'FAST_INSTANT_TRADE_PAY',                         //销售产品码
                 'total_amount'  =>'66.66',                                          //订单总金额
                 'subject'        =>'测试订单:'.mt_rand(11111,99999),                 // 订单标题
             ];

             //公共请求参数
             $pub_param=[
                 'app_id'        =>'2016101500692808',                //支付宝分配给开发者的应用ID
                 'method'        =>'alipay.trade.page.pay',           //接口名称
                 'charset'       =>'utf-8',                           //请求使用的编码格式
                 'sign_type'     =>'RSA2',                            //商户生成签名字符串所使用的签名算法类型
                 'timestamp'     =>date("Y-m-d H:i:s"),               //   发送请求的时间
                 'version'       =>'1.0',                             //   调用的接口版本
                 'biz_content'  =>json_encode($common_param)          //
             ];

             $params=array_merge($common_param,$pub_param);
             echo "排序前: <pre>";print_r($params);echo "</pre>";

             //筛选并排序
             ksort($params);
             echo "排序后: <pre>";print_r($params);echo "</pre>";echo "<hr>";

             //拼接得到待签名字符串
             $str='';
             foreach($params as $k=>$v){
                 $str.=$k.'='.$v.'&';
             }
             $str=rtrim($str,'&');
             echo "待签名字符串:".$str;echo "<hr>";

             //调用签名函数  得到签名$sign  并base64编码
             $priv_key_id=file_get_contents(storage_path('keys/priv_api.key'));
             openssl_sign($str,$sign,$priv_key_id,OPENSSL_ALGO_SHA256);
             echo "签名 sign:".$sign;echo "<br>";
             echo "base64:".base64_encode($sign);
             $signtrue=base64_encode($sign);

             //将签名加入url参数中
             $request_url=$url.'?'.$str.'&sign='.urlencode($signtrue);
             echo "request_url:".$request_url;

             header("Location:".$request_url);

          }

}
