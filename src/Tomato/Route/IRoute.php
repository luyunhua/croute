<?php
/**
 * Created by luyh@59store.com.
 * User: luyh
 * Date: 16/6/1
 * Time: 下午7:53
 */

namespace Tomato\Route;


interface IRoute
{
    public function put($route=[]);

    public function get($key);

    public function match($method = 'GET', $path = '');



}