<?php

namespace core\library;


class Lu {
    public static $classMap = array();

    public static function load($class) {


        if (!isset(self::$classMap[$class])) {
            $class = str_replace('\\', '/', $class);
            $file  = ROOT . '/' . $class . '.class.php';
            if (is_file($file)) {
                include ROOT . '/' . $class . '.class.php';
                self::$classMap[$class] = $class;
            }
        }
    }

    public static function run() {
        $route    = new Route();
        $module   = $route->module;         // 获取到URL中的module  admin||home
        $ctrlName = $route->controller;     // 获取到URL中的controller name ==》 Index
        $actName  = $route->action;         // 获取到URL中的action name ==》 index

        $ctrlFile = APP_PATH . '/controller/' . $module . '/' . $ctrlName . 'Controller.class.php';
        if (is_file($ctrlFile)) {
            include APP_PATH . '/controller/' . $module . '/' . $ctrlName . 'Controller.class.php';
            $ctrlClass  = '\application\controller\\' . $module . '\\' . $ctrlName . 'Controller';
            $controller = new $ctrlClass();
            $controller->$actName();
        }
    }
}