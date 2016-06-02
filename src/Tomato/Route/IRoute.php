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
    public function add($route=[]);

    public function xget($key);

    public function match($method = 'GET', $path = '');

    public function get($pattern = '', $ctrl = '');

    public function post($pattern = '', $ctrl = '');

    public function put($pattern = '', $ctrl = '');

    public function delete($pattern = '', $ctrl = '');

    public function header($pattern = '', $ctrl = '');


}