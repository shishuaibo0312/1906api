<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class Apibrush
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url=substr(md5($_SERVER['REQUEST_URI']),5,8);
            echo $url;
            echo "<br>";

            $ua=substr(md5($_SERVER['HTTP_USER_AGENT']),5,8);
            echo $ua;
            echo "<br>";

            $key='url:ua'.$url.':'.$ua;
            echo $key;
             echo "<br>";
            $count=Redis::get($key)+1;
            echo "当前访问次数：".$count;
             echo "<br>";
            $max=10;
            if($count>=$max){
               // Redis::expire($key,10); 
                echo "请不要频繁刷新页面,10s后可以刷新";
                echo "<br>";
                echo  "访问次数最大值".$count;die;
            }
            Redis::incr($key);
            Redis::expire($key,10);
        return $next($request);
    }
}
