<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestApi extends Controller
{
    //测试签名
    	function test1(){
    		$key="1906";    

	        $data=$_GET['data'];  //接收的数据
	       
	        
	        $sign=$_GET['sign'];  //接收的签名

	        
	        $sign2=md5($key.$data);
	        echo "接收端计算的签名:".$sign2;
	        echo "<br>";echo "<br>";
	        //echo $sign;
	        echo "<br>";echo "<br>";
	        //检测是否相等
	        if($sign2==$sign){
	            echo "验证签名成功  数据完整";
	        }else{
	            echo "验证签名失败  数据损坏";
	        }


    	}

    //测试加密与解密chr   ord
    	function test2(){
    		$miwen=$_GET['miwen'];
    		$length=strlen($miwen);
    		$yuanwen='';
    		for ($i=0; $i <$length ; $i++) { 
    			$yuanwen.=chr(ord($miwen[$i])-3);
    		}
    		
    		echo "原文：".$yuanwen;
    	}


    //测试加密与签名  对称性加密
    	function test3(){
    		$key='1906';    			 //双方共用的key
    		$data=$_GET['result'];		 //接受的数据
    		$data=base64_decode($data);	 //将接受的数据用base64_decode解码
    		$sign=$_GET['sign'];
    		$method='aes-128-cbc';  	//加密的方法
    		$iv='abcdefg123456789';		//保证16个字节
    		// openssl_decrypt ( string $data , string $method , string $key [, int $options = 0 [, string $iv = "" [, string $tag = "" [, string $aad = "" ]]]] ) : string
    		$result=openssl_decrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
    		$sign2=md5($key.$result);		//接收方签名
    		if($sign==$sign2){
    			echo "验证签名成功  数据完整"."<br>"; 
    			echo "base64_encode编码后的数据:".$data."<br>";
    			echo "接受的数据：".$result;
    		}else{
    			echo "验证签名失败  数据损坏";
    		}
 
    	}

    //非对称性加密
    	function  test4(){
    		$data=$_GET['data'];
    		$key=file_get_contents(storage_path('keys/priv_api.key'));		//私钥
    		//openssl_private_decrypt ( string $data , string &$decrypted , mixed $key [, int $padding = OPENSSL_PKCS1_PADDING ] ) : bool
    		$data=base64_decode($data);
            //echo $data;
    		openssl_private_decrypt($data,$jiemi,$key);
    		//echo "解密的数据为：".$jiemi;
            $res='ok';
            $key2=file_get_contents(storage_path('keys/pub_wx.key'));
            openssl_public_encrypt($res,$data2,$key2);
            return $data2;
            

    	}


    //验证非对称性签名
        function  test5(){
            $sign=$_GET['sign'];
            //echo $sign."<br>";
            $data=$_GET['data'];
            $sign=base64_decode($sign);
            $key=openssl_pkey_get_public("file://".storage_path('keys/pub_wx.key'));
            //echo $key;
           // $key=openssl_pkey_get_private("file://".storage_path('keys/pub_wx.key'));
            //openssl_verify ( string $data , string $signature , mixed $pub_key_id [, mixed $signature_alg = OPENSSL_ALGO_SHA1 ] ) : int
            $res=openssl_verify($data,$sign,$key,OPENSSL_ALGO_SHA1);
            if($res==1){
                echo "签名验证成功  数据完整";
            }else if($res==0){
                echo "数据验证失败  数据损坏";
            }else{
                echo "内部错误";
            }
        }
}
