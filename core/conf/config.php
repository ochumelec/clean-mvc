<?php
namespace conf;

Final Class AparserConfig
{
    public static $_host = 'http://127.0.0.1:9091/API';
    public static $_password = 'password';
    public static $_options = array();
    public static $_request_delay = 1;
    public static $_se_arr = array(
        'google' => array(
            'parser' => 'SE::Google',
            'preset' => 'domains_checker_g_ru'
        ),
        'yandex' => array(
            'parser' => 'SE::Yandex',
            'preset' => 'domains_checker_ya_ru'
        )
    );
}

Final Class Cronconfig
{
    public static $_path = '/home/www/ap.local/';
}

Final Class Dbconfig
{
    public static $_user = 'postgres';
    public static $_pass = 'password';
    public static $_host = '127.0.0.1';
    public static $_db = 'database';
}
