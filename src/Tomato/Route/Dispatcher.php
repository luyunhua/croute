<?php
/**
 * Created by luyh@59store.com.
 * User: luyh
 * Date: 16/5/30
 * Time: 下午8:26
 */

namespace Tomato\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Author     : luyh@59store.com
 * CreateTime : ${DATE} ${TIME}
 * Description: [转发器]
 * Class Dispatcher
 * @package Tomato\Route
 */
class Dispatcher
{
    private $route;
    private $request;

    public function __construct(IRoute $route)
    {
        $this->route = $route;
        $this->request = Request::createFromGlobals();
    }

    public function run()
    {
        $path = $this->request->get('_url');
        $method = $this->request->getRealMethod();
        $match = $this->route->match( $method, $path );
        if( !$match ) {
            throw new \Exception('route is not exist');
        }
        if ( is_callable($match['callback']) ) {
            return call_user_func($match['callback']);
        }

        $ctrlList = explode('@', $match['callback']);

        if ( count($ctrlList) != 2 ) {
            throw new \Exception('parameter callback exception');
        }

        $ctrl = $ctrlList[0];
        $action = $ctrlList[1];

        if (!class_exists($ctrl)) {
            throw new \Exception("{$ctrl} Not Found");
        }

        $class = new $ctrl;
        if (!method_exists($class, $action)) {
            throw new \Exception("{$action} method is not defined In class {$ctrl} ");
        }
        $class->$action();
    }

    //资源回收
    public function __destruct()
    {
        $this->route = null;
        $this->request = null;
    }

}