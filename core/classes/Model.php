<?php
namespace model;
require_once(dirname(__FILE__) . '/../interfaces/modelInterface.php');
Class Model
{
    protected $db;

    public function __construct()
    {
        global $DATABASE;
        require_once(dirname(__FILE__).'/../lib/DbSimple/config.php');
        $this->db = $DATABASE;
    }
}

?>