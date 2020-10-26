<?php
namespace view;

CLass View
{
    public $title;
    public $page;

    public $layout = true;
    public $show_menu = true;
    public $show_header = true;
    public $show_footer = true;
    public $show_sidebar = false;
    public $show_center = true;
    public $sidebar_menu = array();

    public function __construct()
    {
        $this->title = 'Domains checker';
    }

    public function __get($var)
    {
        // no action
    }

    public function __destruct()
    {
        if ($this->layout) {
            $this->draw_page();
        }
    }

    public function draw_page()
    {
        require_once(dirname(__FILE__) . '/../views/main.php');
    }

    public function load_part($name)
    {
        $pre = ob_get_clean();
        @ob_start();
        require_once(dirname(__FILE__) . '/../views/custom_views/' . $name . '.php');
        $part = ob_get_clean();
        echo $pre;
        return $part;
    }

    public function check_permission($group)
    {
        return in_array($group, $this->current_user['groups']);
    }


}

?>