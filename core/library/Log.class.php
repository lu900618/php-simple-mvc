<?php


namespace core\library;


class Log {
    public static $class;

    public static function init() {
        $driver = Config::get('DRIVER', 'log');
        $class  = '';
        switch ($driver) {
            case 1:
                $class = '\core\library\Log2File';
                break;
            case 2:
                $class = '\core\library\Log2Mysql';
                break;

        }
        self::$class = new $class();
    }

    public static function log($msg) {
        self::init();
        self::$class->log($msg);
    }
}