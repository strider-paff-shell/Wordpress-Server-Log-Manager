<?php
namespace serverlogmanager\app\LogHighlight;
use serverlogmanager\lib\Utils\Utils;

if (!defined( 'WPINC'))
{
    die();
}

class LogHighlight
{
    public static function highlightLogtypes($line)
    {
        if(preg_match('/(critical)|(criti)/i', $line))
        {
            return "<p style=\"background: #000; color: #ff0000;\">" . nl2br(Utils::filter_str($line)) . "</p>";
        }
        elseif(preg_match('/(fatal)/i', $line))
        {
            return "<p style=\"background: #B80700; color: #000;\">" . nl2br(Utils::filter_str($line)) . "</p>";
        }
        elseif(preg_match('/(error)|(erro)/i', $line))
        {
            return "<p style=\"background: #ff0000; color: #000;\">" . nl2br(Utils::filter_str($line)) . "</p>";
        }
        elseif(preg_match('/(warning)|(warn)/i', $line))
        {
            return "<p style=\"background: #ffdd00; color: #000;\">" . nl2br(Utils::filter_str($line)) . "</p>";
        }
        else
        {
            return "<p>" . nl2br(Utils::filter_str($line)) . "</p>";
        }
    }

    public static function highlightAttacks($line)
    {
        if(preg_match('/(alert)|(\">)|(document.cookie)|(document.)|(img)|(src)|(onerror)/i', $line))
        {
            return "<p style=\"background: #ff0000; color: #fff;\">[POSSIBLE XSS DETECTED] " . nl2br(Utils::filter_str($line)) . "</p>";
        }
        elseif(preg_match('/(union)|(select)|(from)|(user)/i', $line))
        {
            return "<p style=\"background: #ff0000; color: #fff;\">[POSSIBLE SQLI DETECTED] " . nl2br(Utils::filter_str($line)) . "</p>";
        }
        elseif(preg_match('/(xmlrpc)/i', $line))
        {
            return "<p style=\"background: #ff0000; color: #fff;\">[POSSIBLE XMLRPC-ATTACK DETECTED] " . nl2br(Utils::filter_str($line)) . "</p>";
        }
        elseif(preg_match('/(xmlrpc)/i', $line))
        {
            return "<p style=\"background: #ff0000; color: #fff;\">[POSSIBLE XMLRPC-ATTACK DETECTED] " . nl2br(Utils::filter_str($line)) . "</p>";
        }
        else
        {
            return "<p>" . nl2br(Utils::filter_str($line)) . "</p>";
        }
    }
}