<?php
namespace serverlogmanager\controller;
if (!defined( 'WPINC'))
{
    die();
}

use serverlogmanager\app\core;
use serverlogmanager\lib\Utils\Utils;

class Admin_Tools_Page_Edit
{
	private static $instance;
	
	public static function getInstance($base_path)
	{
		if(is_null( self::$instance ))
		{
			self::$instance = new Admin_Tools_Page_Edit($base_path);
		}

		return self::$instance;
	}

	private function __construct($base_path)
	{
		$this->capability_required = 'activate_plugins';

		if(is_multisite()) 
		{
			$this->capability_required = 'manage_network';
	    }

		add_action('admin_init', array( $this, 'init_actions'));
		$this->base_path = $base_path;
	}




	public function run_action($view)
	{
		if(isset($_GET['_action']))
        {
            switch ($_GET['_action'])
            {
                case 'clear':
                    core::getInstance()->clearLogFileList();
                    break;
                case 'add':
                    if(isset($_GET['logfile']))
                    {
                        $logfile = Utils::filter_str($_GET['logfile']);
                        core::getInstance()->addLogFile($logfile);
                        header('location: tools.php?page=serverlogmanager&_view=edit');
                    }

                    break;
                case 'delete':
                    if(isset($_GET['logfile']) && isset($_GET['_nounce']))
                    {
                        $logfile = Utils::filter_str($_GET['logfile']);
                        $chksum = Utils::filter_str($_GET['_nounce']);
                        if(hash('sha256', $logfile) == $chksum)
                        {
                            core::getInstance()->deleteLogFile($logfile);
                        }

                    }

                    break;

                default:
                    break;
            }
        }
        $view->assign('title', 'Edit settings');
        $view->assign('logfiles', core::getInstance()->getLogfiles());
	}
}