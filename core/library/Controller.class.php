<?php


namespace core\library;


class Controller {
    public static $assign = array();

    public function assign($name, $value) {
        self::$assign[$name] = $value;
    }

    /**
     * @param $view 模板名
     */
    public function display($view) {
        extract(self::$assign);
        $file = APP_PATH . '/view/' . $GLOBALS['module'] . '/' . $view . '.html';
        if (is_file($file)) {
            include $file;
        }
    }

    public function redirect($url, $msg = '', $wait = 3) {
        $url = str_replace(array("\n", "\r"), '', $url); // 多行URL地址支持
        if (headers_sent()) {
            $str = "<meta http-equiv='Refresh' content='{$wait};URL={$url}'>";
            if ($wait != 0) {
                $str .= $msg;
            }
            exit($str);
        } else {
            if (0 === $wait) {
                header("Location: " . $url);
            } else {
                header("Content-type: text/html; charset=utf-8");
                header("refresh:{$wait};url={$url}");
                echo($msg);
            }
            exit();
        }
    }
}