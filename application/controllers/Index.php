<?php
/**
 * @name IndexController
 * @author songxiyao
 */
class IndexController extends Controller {

    public function indexAction() {
        /*layout*/
        $this->_layout->title = '管理后台';
        //查询用户列表
        $user = new UserModel();
        $params = array(
            'field' => '*',
            'where' => array(),
            'order' => 'id desc',
            //'limit'  => 1,
            //'offset' => 1,
            //'page'   => $this->_page,
            //'per'    => 1,
        );
        $data = array(
            'userList' => $user->getList($params),
        );
        $this->_view->data = $data;
    }

    public function addAction() {
        $this->_layout->title = '添加';
    }

    public function editAction() {
        Yaf_Dispatcher::getInstance()->disableView();//关闭自动渲染
        $this->_layout->title = '编辑';
        $data = array(

        );
        $this->_view->data = $data;
        echo $this->render("add");//手动指定视图文件
    }
}
