<?php
namespace controllers;

use view\View;

require_once(dirname(__FILE__) . '/../interfaces/controllerInterface.php');

Class Controller
{
    protected $view;
    protected $auth;
    protected $action_id;
    protected $site_path = '';
    protected $user;

    public function __construct()
    {

        $this->view = new View();

        if (!isset($_SERVER['argv']) && $this->_get_site_path() != 'api') {
            $this->view->site_path = $this->_get_site_path();
            $this->view->controller = $this->_controller();
            $this->view->action = $this->_action();
//            require_once(dirname(__FILE__) . '/../lib/AuthLibrary.php');
//            $this->auth = new \AuthLibrary();
//            $this->user = $this->auth->user;
//            $this->view->current_user = $this->user;
//            $auth_hash = (isset($_COOKIE['auth_hash'])) ? $_COOKIE['auth_hash'] : false;
//            $this->view->check_login = $this->auth->_checkLogin($auth_hash);
        }
    }

    public function __call($method, $data)
    {

        die(__CLASS__ . ' -> "' . $method . '" not found.');
    }

    private function _controller()
    {
        $url_ex = $this->_parse_url();
        return (isset($url_ex[1]) && $url_ex[1]) ? $url_ex[1] : 'index';
    }

    private function _action()
    {
        $url_ex = $this->_parse_url();
        return (isset($url_ex[2]) && $url_ex[2]) ? $url_ex[2] : 'index';

    }

    private function _get_site_path()
    {
        $url_ex = $this->_parse_url();
        return (isset($url_ex[0]) && $url_ex[0]) ? $url_ex[0] : 'index';
    }

    private function _parse_url()
    {
        $url = parse_url($_SERVER['REQUEST_URI']);

        $url['path'] = ltrim($url['path'], '/');
        $url_ex = explode('/', $url['path'], 4);
        return $url_ex;
    }

    public final function load_model($model)
    {
        require_once(dirname(__FILE__) . '/../models/' . $model . 'Model.php');
        $model_name = '\model\\' . $model . 'Model';
        return new $model_name;
    }

    public final function redirect($url = '/')
    {
        @ob_clean();
        header('Location: ' . $url);
        $this->view->layout = false;
        exit();
    }

    public final function refreshPage()
    {
        @ob_clean();
        header('Location: ' . $_SERVER['REQUEST_URI']);
        $this->view->layout = false;
        exit();
    }
}

?>