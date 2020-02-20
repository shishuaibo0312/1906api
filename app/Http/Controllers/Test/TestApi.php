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
}
