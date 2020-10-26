<?php
namespace controllers;

Class alertController extends Controller implements controllerInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        die;
    }

    public function get_all()
    {
        session_start();

        $this->view->layout = false;

        if (isset($_SESSION['alerts'])) {
            echo $_SESSION['alerts'];
            unset($_SESSION['alerts']);
        } else {
            echo 'false';
        }
    }

    public function set()
    {
        session_start();
        $this->view->layout = false;

        if (isset($_POST['alerts'])) {
            $_SESSION['alerts'] = $_POST['alerts'];
        } else {
            echo 'set options empty!';
        }
    }


}

?>