<?php
if (!defined( 'WPINC'))
{
    die();
}

class autoloader
{
    public function __construct()
    {
        spl_autoload_register(array($this, 'load_class'));
    }

    public function load_class($class)
    {
        $file = plugin_dir_path( __FILE__ ) . '/';
        $file .= str_replace('\\', '/', $class) . '.php';
        if(strpos($class, "serverlogmanager") !== false)
        {
            if(file_exists($file))
            {

                require_once $file;
            }
            else
            {
                $message = "<div id=\"message\" class=\"notice notice-error\">Fatal error: Class $file not found!</div>";
                die($message);
            }

        }
    }

    public static function register()
    {
        new autoloader();
    }
}