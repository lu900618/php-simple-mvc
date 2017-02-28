<?php


namespace core\library;


class Route {

    public  $module, $controller, $action;

    function __construct() {
        $path = $_SERVER['REQUEST_URI'];
        if (DEBUG) {
            Log::log('$_SERVER[\'REQUEST_URI\']==>' . $_SERVER['REQUEST_URI']);
        }
        if (isset($path)) {
            if ($path === '/') {
                $this->controller = 'Index';
                $this->action     = 'index';
                $this->module     = 'home';
            } else {
                $patharr = explode("/", ltrim($path, '/'));
                if (isset($patharr[0])) {
                    if ($patharr[0] === 'a') { // NOTICE: 分组为a 即是后台
                        $this->module = 'admin';
//                        unset($patharr[0]);
                        array_splice($patharr, 0, 1); //弹出arr[0] 重建索引
                    } else {
                        $this->module = 'home';
                    }
                }
                // NOTICE: 获取Controller名字
                if (isset($patharr[0])) {
                    $this->controller = $patharr[0];
                    unset($patharr[0]);
                }
                // NOTICE: 获取Action名字
                if (isset($patharr[1])) {
                    $this->action = $patharr[1];
                    unset($patharr[1]);
                }
                // NOTICE: 获取属性名和对应参数
                $count = count($patharr);
                if ($count >= 2) {
                    for ($i = 2; $i <= $count; $i += 2) {
                        $_GET[$patharr[$i]] = $patharr[$i + 1];
                    }
                }
            }
            if (DEBUG) {
                Log::log('MODULE==>' . $this->module . PHP_EOL
                    . 'CONTROLLER==>' . $this->controller . PHP_EOL
                    . 'ACTION==>' . $this->action . PHP_EOL);
            }
            $GLOBALS['module'] = $this->module;
        }
    }
}