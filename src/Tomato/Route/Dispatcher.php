<?php
/**
 * Created by luyh@59store.com.
 * User: luyh
 * Date: 16/5/30
 * Time: 下午8:26
 */

namespace Tomato\Route;
use Symfony\Component\HttpFoundation\Request;


class Dispatcher
{
    private $route;
    private $currentRoute;
    private $path;
    private $request;
    public function __construct(Route $route)
    {
        $this->route = $route;
        $this->request = Request::createFromGlobals();
        $this->init();
    }

    public function init()
    {
        $this->setPath($this->request->get('_url'));
        $this->parseRoute();
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }


    public function parseRoute()
    {
        foreach ($this->route->getRoutes() as $k => $v) {
            //替换路由中所有的/变为\/
            $v['pattern'] = str_replace('/', '\/', $v['pattern']);
            if ( strpos($v['pattern'], '[number]')) {
                $v['pattern'] = str_replace('[number]', '\d+', $v['pattern']);
            }

            if ( strpos($v['pattern'], '[string]')) {
                $v['pattern'] = str_replace('[string]', '\w+', $v['pattern']);
            }

            if ($ret = preg_match("/^{$v['pattern']}$/i", $this->path)) {
                $this->setCurrentRoute($v);
                return $k;
            }
            throw new NotFoundException('route not found');
        }

    }

    public function setCurrentRoute ($currentRoute)
    {
        $this->currentRoute = $currentRoute;
    }

    public function  getCurrentRoute()
    {
        return $this->currentRoute;
    }



    public function run()
    {
        $currentRoute = $this->getCurrentRoute();
        if ( is_callable($currentRoute['callback']) ) {
            return call_user_func($currentRoute['callback']);
        }
        $caList = explode('@', $currentRoute['callback']);
        if ( count($caList) != 2 ) {
            throw new \Exception('parameter callback exception');
        }

        $ctrl = $caList[0];
        $action = $caList[1];

        $class = new $ctrl;
        $class->$action();
    }

    //资源回收
    public function destroy()
    {

    }

}