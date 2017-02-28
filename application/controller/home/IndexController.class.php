<?php


namespace application\controller\home;


use core\library\Controller;

class IndexController extends Controller {
    public function index() {
//        $data = "hello";
//        $this->assign('data', $data);
//        $this->display('index');
        $this->redirect('a/Index/index');
    }
}