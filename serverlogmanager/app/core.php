<?php
namespace serverlogmanager\app;
if (!defined( 'WPINC'))
{
    die();
}

use serverlogmanager\app\LogHighlight\LogHighlight;
use serverlogmanager\app\Wordpress\WPAPI;
use serverlogmanager\lib\Utils\Utils;

class core
{
    private static $instance = null;

    public static function getInstance()
    {
        if(self::$instance == null)
            self::$instance = new self();

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function getLogfiles()
    {
        return WPAPI::getLogfiles();
    }

    public function addLogFile($file)
    {
        WPAPI::addLogFile($file);
    }

    public function deleteLogFile($logfile)
    {
        WPAPI::deleteLogFile($logfile);
    }

    public function clearLogFileList()
    {
        WPAPI::clearLogFileList();
    }

    public function readLog($file)
    {
        $lines = "<code>";
        $handle = fopen($file, "r");
        if($handle)
        {
            while ($buffer = fgets($handle, 65536))
            {
                $line = LogHighlight::highlightLogtypes($buffer);
                if($line == LogHighlight::highlightAttacks($buffer))
                {
                    $lines .= $line;
                }
                else
                {
                    $lines .= LogHighlight::highlightAttacks($buffer);
                }


            }

            fclose($handle);
        }

        return $lines."</code>";
    }
}

