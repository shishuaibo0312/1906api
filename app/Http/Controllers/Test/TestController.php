<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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
}
