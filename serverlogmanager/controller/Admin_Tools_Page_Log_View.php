<?php
namespace serverlogmanager\controller;
if (!defined( 'WPINC'))
{
    die();
}

use serverlogmanager\app\core;
use serverlogmanager\lib\Utils\Utils;
use serverlogmanager\view\MessageBoxView;

class Admin_Tools_Page_Log_View
{
	private static $instance;
	
	public static function getInstance($base_path)
	{
		if(is_null( self::$instance ))
		{
			self::$instance = new Admin_Tools_Page_Log_View($base_path);
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

		$this->base_path = $base_path;
	}

    public function readLog($file) //todo add the feature to highlight logtypes
    {
        $file = Utils::filter_str($file);
        if(!is_null($file))
        {
            if(is_readable($file))
            {
                return core::getInstance()->readLog($file);
            }
            else
            {
                $msgbox = new MessageBoxView();
                $msgbox->assign('type', 'error');
                $msgbox->assign('log_file', $file);
                $msgbox->assign('message_type', "file_not_found");
                return $msgbox->render();
            }
        }
        else
        {
            $msgbox = new MessageBoxView();
            $msgbox->assign('type', 'error');
            $msgbox->assign('log_file', "");
            $msgbox->assign('message_type', "file_is_null");
            return $msgbox->render();
        }

    }

	public function run_action($view)
	{
		$view->assign('title', 'View logs');
		$view->assign('logfiles', core::getInstance()->getLogfiles());
		if(isset($_GET['log']))
		{
			$view->assign(
				'log_content', 
				$this->readLog($_GET['log'])
			);
		}
		else
		{
			$msgbox = new MessageBoxView();
			$msgbox->assign('type', 'info');
			$msgbox->assign('log_file', "");
			$msgbox->assign('message_type', "");
			$view->assign('log_content', $msgbox->render());
		}
	}
}