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


    public function add($route=[])
    {
        //print_r($route);
        $this->routesList[$route['pattern']]  = $route;
    }

    public function xget($key)
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
            $regx = "/^\/?{$v}\/?$/i";
            if ($ret = preg_match($regx, $path)&&
                $method == $this->xget($originKey)['method']) {

                return $this->xget($originKey);
            }

        }
        return false;
    }

    public function get($pattern = '', $ctrl = '')
    {
        $this->add([
            'method' => 'GET',
            'pattern' => $pattern,
            'callback' => $ctrl
        ]);
    }

    public function post($pattern = '', $ctrl = '')
    {
        $this->add([
            'method' => 'POST',
            'pattern' => $pattern,
            'callback' => $ctrl
        ]);
    }

    public function put($pattern = '', $ctrl = '')
    {
        $this->add([
            'method' => 'PUT',
            'pattern' => $pattern,
            'callback' => $ctrl
        ]);
    }

    public function delete($pattern = '', $ctrl = '')
    {
        $this->add([
            'method' => 'DELETE',
            'pattern' => $pattern,
            'callback' => $ctrl
        ]);
    }

    public function header($pattern = '', $ctrl = '')
    {
        $this->add([
            'method' => 'HEADER',
            'pattern' => $pattern,
            'callback' => $ctrl
        ]);
    }


}