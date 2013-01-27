<?php
//    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    date_default_timezone_set('UTC');
    session_start();
    
    require_once 'module.php';
    require_once 'setup.php';
    require_once 'steps.php';
    
    function __autoload($name)
    {
        global $setup;
        $path = '';
        if($name == 'User')
        {
            return;
        }
        if(@in_array($name, $setup->modules) || @in_array($name, $setup->main_modules))
        {
            $path .= 'modules/';
        }
        elseif(false !== strpos(strtolower($name), 'step'))
        {
            $path .= 'step/';
        }
        include_once $path.$name.'.php';
    }
?>