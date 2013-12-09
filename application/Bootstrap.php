<?php
/**
 * @name Bootstrap
 * @author songxiyao
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract {
    private $_config;

    public function _initConfig() {
        //把配置保存起来
        $this->_config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $this->_config);
    }

    /*
     * 注册本地类库前缀
     */
    public function _initNamespaces() {
        Yaf_Loader::getInstance()->registerLocalNameSpace(array("Zend"));
    }

    /*
     * 数据库
     */
    public function _initDefaultDbAdapter() {
        $params = $this->_config->application->db->toarray(); //读取数据库配置，并转成array格式
        $db = new Zend_Db_Adapter_Pdo_Mysql($params); //采用pdo方式，链接mysql
        Zend_Db_Table::setDefaultAdapter($db); //为所有的Zend_Db_Table对象设定默认的adapter
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher) {
        //在这里注册自己的路由协议
       /* $router = Yaf_Dispatcher::getInstance()->getRouter();
        $route = new Yaf_Route_Regex("#^/([^/]+)/edit/(.*)/#", array("controller" => ":c", 'action' => "edit"), array(1 => ":c", 2 => 'id'));
        //$route = new Yaf_Route_Rewrite(':c/edit/:id', array('controller' => ':c', 'action' => 'edit'));
        $router->addRoute("edit", $route);*/
    }

    /*
     * 设置页面layout
     */
    public function _initLayout(Yaf_Dispatcher $dispatcher) {
        $layout = new LayoutPlugin("layout.phtml");
        Yaf_Registry::set('layout', $layout);
        $dispatcher->registerPlugin($layout);
    }
}
