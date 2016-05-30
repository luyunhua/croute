<?php
namespace Tomato\Route;
/**
 * Created by luyh@59store.com.
 * User: luyh
 * Date: 16/5/30
 * Time: 下午3:21
 */
class Route
{
    private $routes = array();

    public function addRoute ($method = '', $uri='', $callback = '')
    {
        array_push($this->routes, ['method' =>$method, 'uri' =>$uri, 'callback' =>$callback]);
    }

    public function getRoutes()
    {
        return $this->routes;
    }




}