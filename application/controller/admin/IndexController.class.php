<?php


namespace application\controller\admin;


use core\library\Controller;
use core\library\Model;

class IndexController extends Controller {
    public function index() {
        Model::getInstance();
        $this->display('index');
    }
}