<?php
/**
 * Created by PhpStorm.
 * User: songxiyao
 * Date: 13-12-4
 * Time: 下午9:25
 */
class Controller extends Yaf_Controller_Abstract {
    protected $_layout;
    protected $_page;
    protected $_userInfo;

    public function init() {
        if (!isset($_SESSION['user_info'])) {
            header("Location:/login");
            exit;
        }
        $this->_userInfo = $_SESSION['user_info'];
        $this->_layout = Yaf_Registry::get('layout');
        $this->_page = (int)($this->getRequest()->getQuery("page")) != 0 ? abs($this->getRequest()->getQuery("page")) : 1;
    }
}