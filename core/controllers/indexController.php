<?php
namespace controllers;

Class indexController extends Controller implements controllerInterface
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = $this->load_model('index');
    }

    public function index()
    {
        $this->view->page = $this->view->load_part('index');
    }


}

?>