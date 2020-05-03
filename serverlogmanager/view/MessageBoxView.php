<?php
namespace serverlogmanager\view;

if (!defined( 'WPINC'))
{
    die();
}

class MessageBoxView extends BaseView
{
    public function __construct()
    {
        
    }

    public function render()
    {
        ob_start();
        $template = plugin_dir_path( __FILE__ ) . '../templates/messagebox/messagebox.phtml';
        if (!is_file($template))
        {
            return "";
        }

        include $template;
        $view = ob_get_clean();
        return $view;
    }
}