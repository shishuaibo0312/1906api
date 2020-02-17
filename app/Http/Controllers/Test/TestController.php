<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
class TestController extends Controller
{
    //
	    function test(){
	    	$key='1906';
	    	$val=time();
	    	Redis::set($key,$val);
	    	$value=Redis::get($key);
	    	echo 'value:'.$value;
	    	}

	    function test2(){
	    	$data=date('Y-m-d h:i:s');
	    	echo $data;
	    }

    //测试file_get_contents()
    	function test3(){
    		$APPID='wxaaa2d2a93479357f';
    		$APPSECRET='3a7bc660a3533cdedfedf2a8efce3c6d';
    		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$APPID.'&secret='.$APPSECRET;
    		$data=file_get_contents($url);
            var_dump($data);
    	}
    //测试CURL  get方式
    	function test4(){
    		$APPID='wxaaa2d2a93479357f';
    		$APPSECRET='3a7bc660a3533cdedfedf2a8efce3c6d';
    		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$APPID.'&secret='.$APPSECRET;
    		$curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//关闭https验证
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
	        $output = curl_exec($curl);
	        curl_close($curl);
	        var_dump($output);
    	}


    //CURL  post方式
     	function test6(){
     		$ACCESS_TOKEN='30_1DITa4IqswJcILmO0UbheMT1bhlb7TP8oJcswPSoXo2iB4mpNq-rPiq9wyxhLFRtIaSuOyTAlZycM6gVzVKK2mtgecRHiCHvJCYcKkaRVNHj9EZ5WTWuBfO6K8KH-ydjHa_ZAy4s54-8qilzCWKcAAAICQ';
     		$url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$ACCESS_TOKEN;
     		 $postData=[
                "button"    => [
                    [
                        "type"  => "location_select",
                        "name"  => "发送位置",
                        "key"   => "rselfmenu_2_0"
                    ]
                ]
            ];
            $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
     		$curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式
	        curl_setopt($curl, CURLOPT_POST, 1);  //设置以post发送
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);   //设置post发送的数据
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //关闭https验证
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
	        $output = curl_exec($curl);
	        curl_close($curl);
	        print_r($output);
     	}

    //测试Guzzle
    	function test5(){
    		$APPID='wxaaa2d2a93479357f';
    		$APPSECRET='3a7bc660a3533cdedfedf2a8efce3c6d';
    		$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$APPID.'&secret='.$APPSECRET;
    		$client=new Client();
			$res = $client->request('GET', $url);
			echo $res->getBody();
			//var_dump($res);				     	
		}


		function test7(){
			$ACCESS_TOKEN='30_OQzw2QSg1bm8VIeWiu0qAnLsdMo5BtRZsxGMdlkN0F4wlixgHYfbw91CwazEKKOEicJA873WAqkw1FmbPVzYGy6vreUDAsUnrwo6_9Q8kliLp_MUmaid2LuUEp8VV-5--_yLg7KvvU1y0UWPZNBeAAAVJX';
     		$url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$ACCESS_TOKEN;
     		$client=new Client();
			$response = $client->request('POST', $url, [
				'form_params' => [
					        'name'  => 'yaoyao',
							'place' => 'hebei',
							'year'  => '23'	 
					        ]
					    
					 
                
			]);
			echo $response->getBody();
		//var_dump($response);
		}
	//测试form-data	
		function test8(){
			echo "api开始";
			echo "<pre>";
			print_r($_POST);
			print_r($_FILES);
			echo "<pre>";	
			echo "api结束";
		}
    //测试urlencoded
		function test9(){
			echo "api开始";
			echo "<pre>";
			print_r($_POST);

			echo "<pre>";	
			echo "api结束";
		}
	//测试raw
		function test10(){
		echo "api开始";
		$json=file_get_contents("php://input");
		$arr=json_decode($json,true);
		echo "<pre>";
		print_r($arr);
		echo "<pre>";	
		echo "api结束";
		}
}
