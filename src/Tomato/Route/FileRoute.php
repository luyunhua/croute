<?php
/**
 * Created by luyh@59store.com.
 * User: luyh
 * Date: 16/6/1
 * Time: 下午8:04
 */

namespace Tomato\Route;


class FileRoute implements IRoute
{
    private $config;
    private $routesList = [];


    public function put($route=[])
    {
        $route['method'] = strtoupper($route['method']);
        $this->routesList[$route['pattern']]  = $route;
    }

    public function get($key)
    {
        return $this->routesList[$key];
    }


    public function match($method = 'GET' ,$path = '')
    {
        $keys = array_keys($this->routesList);
        foreach ($keys as $v) {
            $originKey = $v;
            $v = str_replace('/', '\/', $v);
            if ( strpos($v, '[number]')) {
                $v = str_replace('[number]', '\d+', $v);
            }

            if ( strpos($v, '[string]')) {
                $v = str_replace('[string]', '\w+', $v);
            }
            echo $this->get($originKey)['method'].'<p>';

            $regx = "/^\/?{$v}\/?$/i";
            if ($ret = preg_match($regx, $path)&&
                $method == $this->get($originKey)['method']) {

                return $this->get($originKey);
            }
            return false;
        }
    }
}