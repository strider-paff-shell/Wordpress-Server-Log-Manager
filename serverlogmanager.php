<?php
/**
 * Plugin name: Server log manager
 * Plugin URI:
 * Description: View server logs in the wordpress admin dashboard
 * Version: 1.0
 * Author: @strider-paff-shell
 * Author URI: https://github.com/strider-paff-shell
 * License: GPLv3
 * Text Domain: serverlogmanager
 */

/** Copyright 2019 Strider

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 3, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined( 'WPINC'))
{
    die();
}

use serverlogmanager\controller\Admin_Tools_Page_Main;


define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_PLUGIN_URL', plugins_url());
if (!class_exists('Server_Log_Manager')) :
class Server_Log_Manager 
{
	public static $instance;

	public static function getInstance() 
	{
		if (is_null( self::$instance )) 
		{
      		self::$instance = new Server_Log_Manager();
    	}

    	return self::$instance;
	}

	private function __construct()
	{
        require_once "autoloader.php";
        autoloader::register();
		$admin = Admin_Tools_Page_Main::getInstance();
		$admin->setbase(MY_PLUGIN_URL, MY_PLUGIN_PATH);
		$admin->initView();
		$this->capability_required = 'activate_plugins';
	}

}

endif;

$access_log_viewer = Server_Log_Manager::getInstance();