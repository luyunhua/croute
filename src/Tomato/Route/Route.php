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

    /**
     * Author     : luyh@59store.com
     * Description: [函数简介]
     * @param string $method
     * @param string $pattern
     * @param string $callback
     */
    public function add ($method = '', $pattern='', $callback = '')
    {
        $this->routes[$pattern] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'callback' => $callback
        ];
    }

    /**
     * Author     : luyh@59store.com
     * Description: [函数简介]
     * @param $path
     * @return array
     * @throws NotFoundException
     */
    public function match($path)
    {
        $routes = $this->getAll();
        $keys = array_keys($routes);
        foreach ($keys as $v) {
            $originKey = $v;
            $v = str_replace('/', '\/', $v);
            if ( strpos($v, '[number]')) {
                $v = str_replace('[number]', '\d+', $v);
            }

            if ( strpos($v, '[string]')) {
                $v = str_replace('[string]', '\w+', $v);
            }

            if ($ret = preg_match("/^{$v}\/?$/i", $path)) {
                return $this->get($originKey);
            }
            throw new NotFoundException('route not found');
        }
    }

    /**
     * Author     : luyh@59store.com
     * Description: [函数简介]
     * @return array
     */
    public function getAll()
    {
        return $this->routes;
    }


    /**
     * Author     : luyh@59store.com
     * Description: [函数简介]
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->routes[$key];
    }


    /**
     * Author     : luyh@59store.com
     * Description: [函数简介]
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->routes[$key] = $value;
    }




}