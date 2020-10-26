<?php
namespace core;
ob_start();

Class Router
{
    private $url = '';
    private $_controller = '';
    private $_method = '';

    public function __construct()
    {


        if (
            isset($_SERVER['argv']) &&
            isset($_SERVER['argv'][1]) &&
            isset($_SERVER['argv'][2]) &&
            $_SERVER['argv'][1] && $_SERVER['argv'][2]
        ) {
            $this->_setController($_SERVER['argv'][1]);
            $this->_setMethod($_SERVER['argv'][2]);
        } else {
            $this->url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
            $this->url = preg_replace('/^\//', '', $this->url);

            $this->_setController();
            $this->_setMethod();
        }

        require_once(dirname(__FILE__) . '/classes/Model.php');
        require_once(dirname(__FILE__) . '/classes/Controller.php');
        require_once(dirname(__FILE__) . '/classes/View.php');
        require_once(dirname(__FILE__) . '/functions/functions.php');
    }

    public function run()
    {
        require_once(dirname(__FILE__) . '/controllers/' . $this->_controller . 'Controller.php');

        $c_name = '\controllers\\' . $this->_controller . 'Controller';
        $controller = new $c_name;
        call_user_func_array(array($controller, $this->_method), array());
    }


    private function _setController($controller = false)
    {
        if (!$controller) {
            $url_ex = explode('/', $this->url);
            $controller = ($url_ex[0]) ? $url_ex[0] : 'index';
        }

        $controller_path = dirname(__FILE__) . '/controllers/';
        if (file_exists($controller_path . $controller . 'Controller.php')) {
            $this->_controller = $controller;
        } else {
            $this->_controller = 'error';
        }
    }

    private function _setMethod($method = false)
    {
        if (!$method) {
            $url_ex = explode('/', $this->url);
            $method = (isset($url_ex[1]) && $url_ex[1]) ? $url_ex[1] : 'index';
        }

        $this->_method = $method;
    }
}

?>