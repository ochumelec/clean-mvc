<?php
require_once(dirname(__FILE__) . '/../conf/config.php');
use conf\AuthConfig;

Class AuthLibrary
{
    private $_ip;
    private $_domain;
    private $_site_path;
    private $_cookie_domain;
    private $_entity;
    private $_logged_in;
    private $_controller;
    private $_action;
    private $_auth_hash;

    public $user = false;

    private static $user_ex;
    private static $logged_in_ex;

    public function __construct()
    {
        $this->_ip = AuthConfig::$_ip;
        $this->_domain = AuthConfig::$_domain;
        $this->_site_path = AuthConfig::$_site_path;
        $this->_cookie_domain = AuthConfig::$_cookie_domain;
        $this->_entity = AuthConfig::$_entity;
        $this->_auth_hash = isset($_COOKIE['auth_hash']) ? $_COOKIE['auth_hash'] : '';

        $url = parse_url($_SERVER['REQUEST_URI']);

        $url['path'] = ltrim($url['path'], '/');
        $url_ex = explode('/', $url['path'], 4);

        $this->_controller = (isset($url_ex[0]) && $url_ex[0]) ? $url_ex[0] : 'index';
        $this->_action = (isset($url_ex[1]) && $url_ex[1]) ? $url_ex[1] : 'index';


        if (empty(self::$logged_in_ex)) {
            self::$logged_in_ex = $this->_checkLogin(isset($_COOKIE['auth_hash']) ? $_COOKIE['auth_hash'] : false);
        }

        $this->_logged_in = self::$logged_in_ex;

        if ($this->_controller == 'auth' && $this->_action == 'login' && $this->_logged_in) {
            ob_clean();
            header('Location: /' . $this->_site_path);
            exit;
        }

        if (in_array($this->_controller, array('auth')) && in_array($this->_action, array('login', 'logout'))) {

            //пропуск
            return;
        }

        if (!$this->_logged_in) {
            ob_clean();
            header('Location: /' . $this->_site_path . 'auth/login');
            exit;
        } else {
            if (empty(self::$user_ex)) {
                self::$user_ex = $this->_getUser($_COOKIE['auth_hash']);
            }

            $this->user = self::$user_ex;
        }
    }


    public function _get_controller()
    {
        return $this->_controller;
    }

    public function _get_action()
    {
        return $this->_action;
    }

    private function _getUser($auth_hash)
    {
        try {
            if (!$auth_hash) {
                throw new Exception();
            }

            $user = $this->_curlQuery('getUser', array('hash' => $auth_hash));
            if ($user['status'] != 'success') {
                throw new Exception();
            }
            if (!isset($user['data']) || !$user['data']) {
                throw new Exception();
            }

            return $user['data'];
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function getAllUsers()
    {
        $users = $this->_curlQuery('getAllUsers', array(''));
        if ($users['status'] != 'success') {
            return false;
        }
        return $users['data'];
    }

    public function getUserById($user_id)
    {
        if (!$user_id) {
            return false;
        }

        $user = $this->_curlQuery('getUserById', array('id' => $user_id));
        if ($user['status'] != 'success') {
            return false;
        }
        return $user['data'];
    }


    public function _checkLogin($auth_hash)
    {
        try {
            if (!$auth_hash) {
                throw new Exception();
            }

            $logged = $this->_curlQuery('checkauth', array('hash' => $auth_hash));
            if ($logged['status'] != 'success') {
                throw new Exception(isset($logged['message']) ? $logged['message'] : false);
            }

        } catch (Exception $e) {
            $msg = $e->getMessage();
            if ($msg == 'not permitted') {
                $this->_doNotPermission();
            }
            return false;
        }

        return true;
    }

    private function _doNotPermission()
    {
        ob_clean();
        echo '<h1 style=\'text-align: center;\'>Error. You don\'t have permission!</h1>';
//        header('Location: /' . $this->_site_path . 'auth/error');
        exit;
    }

    public function authentificate($auth_hash)
    {
        ob_clean();
        setcookie('auth_hash', $auth_hash, time() + 60 * 60 * 24 * 7, '/', $this->_cookie_domain, false, true);
        header('Location: /' . $this->_site_path);
        exit;
    }


    public function login($login, $pass)
    {
        $pass = md5($pass);
        return $this->_curlQuery('login', array('login' => $login, 'password' => $pass));
    }

    public function logout()
    {
        $this->_curlQuery('logout', array('hash' => isset($_COOKIE['auth_hash']) ? $_COOKIE['auth_hash'] : false));
        ob_clean();
        header('Location: /' . $this->_site_path);
        exit;
    }

    public function createRight($entity_id, $group, $desc)
    {

        return $this->_curlQuery('createRight',
            array(
                'entity_id' => $entity_id,
                'group' => $group,
                'desc' => $desc,
            ));
    }

    private function _curlQuery($action = false, $data = array())
    {
        try {
            if (!$action) {
                throw new Exception('no action');
            }

            $header = array
            (
                "Host: " . $this->_domain,
                "Request URL: " . $this->_domain . '/query.php',
            );

            $ch = curl_init('https://' . $this->_ip . '/query.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

            $post_data = array(
                'action' => $action,
                'entity' => $this->_entity,
                'data' => $data,
                'auth_hash' => $this->_auth_hash,
                'group' => $this->_controller . '/' . $this->_action,
            );

            $field_string = http_build_query($post_data);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $field_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);


            if (!@json_decode($result) || $info['http_code'] != 200) {
                throw new Exception('connection error');
            }

            return json_decode($result, true);

        } catch (Exception $e) {
            return array(
                'status' => 'error',
                'message' => $e->getMessage(),
            );
        }

    }

}


?>