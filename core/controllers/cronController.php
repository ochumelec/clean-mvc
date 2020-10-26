<?php
namespace controllers;

Class cronController extends Controller implements controllerInterface
{

    public function __construct()
    {
        parent::__construct();
        $this->view->layout = false;
        if (isset($_SERVER['SERVER_PROTOCOL'])) {
            exit('CLI only');
        }
        $this->model = $this->load_model('cron');
    }

    public function __destruct()
    {
        echo PHP_EOL;
    }

    public function index()
    {
        die('index');
    }
    
}

?>