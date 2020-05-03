<?php
namespace serverlogmanager\controller;
if (!defined( 'WPINC'))
{
    die();
}

use serverlogmanager\view\MainView;

class Admin_Tools_Page_Main
{
    private $base_url;
    private $base_path;
    private static $instance;
    private $view;


    public static function getInstance()
    {
        if(is_null( self::$instance ))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $this->capability_required = 'activate_plugins';

        if(is_multisite())
        {
            $this->capability_required = 'manage_network';
        }

        add_action('admin_init', array( $this, 'init_actions'));
        add_action('admin_menu', array( $this, 'add_submenu_page'));
    }

    public function setbase($base_url, $base_path)
    {
        $this->base_url = $base_url;
        $this->base_path = $base_path;
    }

    public function initView()
    {
        $this->view = new MainView('main');
        $this->view->assign('title', 'Server Log Manager');
    }

    public function add_submenu_page()
    {
        add_submenu_page(
            'tools.php',
            __('Server Logs', 'serverlogmanager'),
            __('Server Logs', 'serverlogmanager'),
            $this->capability_required,
            'serverlogmanager',
            array( $this, 'render')
        );
    }

    public function init_actions()
    {
        if(isset($_GET['_view']))
        {
            switch ($_GET['_view'])
            {
                case 'logs':
                    $logPageInstance = Admin_Tools_Page_Log_View::getInstance($this->base_path);
                    $this->view = new MainView('logview');
                    $logPageInstance->run_action($this->view);

                    break;

                case 'edit':
                    $editPageInstance = Admin_Tools_Page_Edit::getInstance($this->base_path);
                    $this->view = new MainView('editview');
                    $editPageInstance->run_action($this->view);
                    break;

                default:
                    $this->view = new MainView('main');
                    $this->view->assign('title', 'Server Log Manager');
                    break;
            }
        }
    }

    public function render()
    {
        $this->view->assign('base_path', $this->base_path);
        $this->view->assign('base_url', $this->base_url);
        $this->view->assign('log', 'fcduf');
        echo $this->view->render();
    }

}