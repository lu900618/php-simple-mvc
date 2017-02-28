<?php


namespace core\library;


class Config {
    public static $conf = array();

    /**
     * 从配置文件读取一项
     * @param $name 要加载的配置项名
     * @param $file 要加载的配置文件名，非路径，无后缀
     * @return mixed
     * @throws \Exception
     */
    public static function get($name, $file) {
        if (isset(self::$conf[$file])) {
            return self::$conf[$file][$name];
        } else {
            $filePath = CORE_PATH . '/conf/' . $file . '.php';
            if (is_file($filePath)) {
                $config = include $filePath;
                if (isset($config[$name])) {
                    self::$conf[$file] = $config;
                    return self::$conf[$file][$name];
                } else {
                    throw new \Exception('没有这个配置项', $name);
                }
            } else {
                throw new \Exception('没找到配置文件', $file);
            }
        }
    }

    /**
     * 从配置文件读取所有配置
     * @param $file 要加载的配置文件名，非路径，无后缀
     * @return mixed
     * @throws \Exception
     */
    public static function getAll($file) {
        if (isset(self::$conf[$file])) {
            return self::$conf[$file];
        } else {
            $filePath = CORE_PATH . '/conf/' . $file . '.php';
            if (is_file($filePath)) {
                return self::$conf[$file] = include $filePath;
            } else {
                throw new \Exception('没找到配置文件', $file);
            }
        }
    }


}