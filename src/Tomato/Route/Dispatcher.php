<?php
/**
 * Created by luyh@59store.com.
 * User: luyh
 * Date: 16/5/30
 * Time: 下午8:26
 */

namespace Tomato\Route;


class Dispatcher
{
    private $route;
    public function __construct($route=null)
    {
        $this->route = $route;
    }

    public function dispatch()
    {
        foreach($this->route->getRoutes() as $k => $v) {
            if (is_callable($v['callback'])){
                call_user_func($v['callback']);
            }
        }

    }

}