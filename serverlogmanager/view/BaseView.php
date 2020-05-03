<?php
namespace serverlogmanager\view;

if (!defined( 'WPINC'))
{
    die();
}

class BaseView
{
	protected $template;
    protected $_data = array();

    public function __construct($template)
    {
    	$this->template = $template;
    }

    public function assign($key, $value)
    {
        $this->_data[$key] = $value;
    }

    public function cloneData($view)
    {
        foreach($this->_data as $key => $value)
        {
            $view->assign($key, $value);
        }
    }
}