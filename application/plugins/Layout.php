<?php
/**
 * @name LayoutPlugin
 * @desc 通用视图
 * @author songxiyao
 */
class LayoutPlugin extends Yaf_Plugin_Abstract {

    private $_layoutDir;
    private $_layoutFile;
    private $_layoutVars = array();

    public function __construct($layoutFile, $layoutDir = null) {
        //定义通用的视图文件
        $this->_layoutFile = $layoutFile;
        //定义通用的视图文件路径
        $this->_layoutDir = ($layoutDir) ? $layoutDir : Yaf_Application::app()->getConfig()->application->layout;
    }

    public function  __set($name, $value) {
        //传给视图的值
        $this->_layoutVars[$name] = $value;
    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        /* get the body of the response */
        $body = $response->getBody();

        /*clear existing response*/
        $response->clearBody();

        /* wrap it in the layout */
        $layout = new Yaf_View_Simple($this->_layoutDir);
        $layout->content = $body;
        $layout->assign('layout', $this->_layoutVars);

        /* set the response to use the wrapped version of the content */
        $response->setBody($layout->render($this->_layoutFile));
    }
}
