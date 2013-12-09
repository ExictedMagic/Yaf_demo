<?php
/**
 * Created by PhpStorm.
 * User: songxiyao
 * Date: 13-12-1
 * Time: 下午4:02
 */
class LoginController extends Yaf_Controller_Abstract {

    protected $_layout;

    public function init() {
        $this->_layout = Yaf_Registry::get('layout');
    }

    public function indexAction() {
        if (isset($_SESSION['user_info'])) {
            header("Location:/");
            exit;
        }
        $this->_layout->title = '登录';
    }

    public function logininAction() {
        $data = $this->getRequest()->getPost("data");
        $user = new UserModel();
        $param = array(
            'field' => array('id', 'username'),
            'where' => array('username' => $data['username'], 'password' => md5($data['password'])),
        );
        $info = $user->getOne($param);
        if ($info) {
            $_SESSION['user_info'] = $info;
            unset($info);
            header("Location:/");
            exit;
        } else {
            header("Location:/login");
            exit;
        }
        //return false; //返回false，将不会调用自动视图引擎Render模板
    }

    public function editAction() {
        $this->_layout->title = '1';
        echo $this->getRequest()->getParam("id");
        return false;
    }

    public function loginoutAction() {
        unset($_SESSION['user_info']);
        header("Location:/login");
        exit;
    }
}