<?php
namespace controllers;

Class errorController extends Controller implements controllerInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->page = $this->view->load_part('error');
    }


}

?>