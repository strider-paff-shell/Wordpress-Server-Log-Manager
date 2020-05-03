<?php
namespace serverlogmanager\view;

if (!defined( 'WPINC'))
{
    die();
}

class MainView extends BaseView
{
    public function render()
    {
        ob_start();
        $template = plugin_dir_path( __FILE__ ) . '../templates/' . $this->template . '.phtml';
        if (!is_file($template))
        {
            return "";
        }

        include $template;
        $view = ob_get_clean();
        return $view;
    }
}