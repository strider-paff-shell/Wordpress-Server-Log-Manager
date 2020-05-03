<?php

namespace serverlogmanager\app\Wordpress;
if (!defined( 'WPINC'))
{
    die();
}

use serverlogmanager\lib\Utils\Utils;

class WPAPI
{
    public static function getLogfiles()
    {
        $logfiles = array();
        foreach (get_option('server_logs') as $logfile)
        {
            $logfiles[] = Utils::filter_str($logfile);
        }

        return $logfiles;
    }

    public static function addLogFile($logfile)
    {
        $logfile = Utils::filter_str($logfile);
        $logfiles = self::getLogfiles();
        $logfiles[] = $logfile;
        if(get_option('server_logs') === false)
        {
            add_option('server_logs', $logfiles);
        }
        else
        {
            update_option('server_logs', $logfiles);
        }
    }

    public static function deleteLogFile($logfile)
    {
        $logfile = Utils::filter_str($logfile);
        $logfiles = self::getLogfiles();
        if(is_array($logfiles))
        {
            $new_logs = array();
            foreach($logfiles as $file)
            {
                if($file != $logfile)
                {
                    $new_logs[] = $file;
                }
            }
            update_option('server_logs', $new_logs);
            return true;
        }

        return false;
    }

    public static function clearLogFileList()
    {
        update_option('server_logs', array());
    }
}