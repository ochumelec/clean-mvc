<?php
namespace controllers;

Class authController extends Controller implements controllerInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->redirect('/auth/login');
    }

    public function login()
    {
        if (isset($_POST) && $_POST) {
            $this->view->layout = false;
            $res = $this->auth->login($_POST['user'], $_POST['password']);
            if ($res['status'] == 'success') {
                $this->auth->authentificate($res['data']['hash']);
            } else {
                $this->redirect('/');
            }

        } else {

            $this->view->title = 'Login';
            $this->view->page = $this->view->load_part('auth');
        }
    }

    public function error()
    {
        $this->view->layout = false;
        echo "<h1 style='text-align: center;'>Error. You don't have permission!</h1>";
        die();
    }

    public function logout()
    {
        $this->view->layout = false;
        $this->auth->logout();
    }


}

?>