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
    private $path;
    private $request;
    private $matchRoute;
    public function __construct(Route $route)
    {
        $this->route = $route;
        $this->request = Request::createFromGlobals();
        $this->init();
    }

    public function init()
    {
        $this->setPath($this->request->get('_url'));
        $this->setMatchRoute();
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }


    public function getMatchRoute()
    {
        return $this->matchRoute;
    }

    public function setMatchRoute()
    {
        $this->matchRoute = $this->route->match($this->path);
    }

    public function run()
    {
        if ( is_callable($this->getMatchRoute()['callback']) ) {
            return call_user_func($this->getMatchRoute()['callback']);
        }
        $ctrlList = explode('@', $this->getMatchRoute()['callback']);
        if ( count($ctrlList) != 2 ) {
            throw new \Exception('parameter callback exception');
        }

        $ctrl = $ctrlList[0];
        $action = $ctrlList[1];

        if (!class_exists($ctrl)) {
            throw new ClassNotFoundException("{$ctrl} Not Found");
        }

        $class = new $ctrl;
        if (!method_exists($class, $action)) {
            throw new FunctionNotFoundException("{$action} method is not defined In class {$ctrl} ");
        }
        $class->$action();
    }

    //资源回收
    public function destroy()
    {

    }

}