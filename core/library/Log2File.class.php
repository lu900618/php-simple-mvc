<?php


namespace core\library;


class Log2File {

    public $path;

    function __construct() {
        $this->path = Config::get('PATH', 'log');
    }

    public function log($msg, $file = 'log') {
        if (!is_dir($this->path . date('Ymd'))) {
            mkdir($this->path . date('Ymd'), 0777, true);
        }

        return file_put_contents(
            $this->path . date('Ymd') . '/' . date('Ymd-H') . $file . '.php',
            '[' . date('Y-m-d H:i:s') . ']:  ' . $msg . PHP_EOL,
            FILE_APPEND
        );
    }
}