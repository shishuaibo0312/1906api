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


    //测试加密与签名
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
    			echo "验证签名失败  数据损坏";die;
    		}
 
    	}
}
