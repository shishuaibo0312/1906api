<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
class UserController extends Controller
{
    //获取用户信息
    	function userinfo(){
    		$userinfo=[
    				'name'   =>  'yaoyao',
    				'sex'    =>	 '2',
    				'year'   =>  '23',
    				'time'   =>  date('Y-m-d h:i:s')
    		];
    		return $userinfo;
    	}

    //用户信息入库
    	function saveuser(){
    		$data=request()->input();
    		//var_dump($data);
    		$id=UserModel::insertGetId($data);
    		echo "自增ID:".$id;
    	}

    
}
