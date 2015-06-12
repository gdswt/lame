<?php
use System\Lib\Config;
final class Application{
	public static $_baseClass=null;
    public static function init()
    {
    	self::autoload();

    }
    public static function run()
    {

    }
    public static function register($serverName)
    {
    	if (is_string($serverName))
		{
			self::_baseClass[$serverName] = self::resolveServer($serverName);
		}

    }
    public static function resolveServer()
    {

    }
    public static function unregister($serverName)
    {
    	if (is_string($serverName))
		{
	    	if (array_key_exists($serverName, self::_baseClass))
			{
                 unset(self::_baseClass[$serverName]);
			}
		}

    }
    public static function autoload()
    {
    	$autoloadClass = config::get("defaultClass");
    	foreach($autoloadClass as $class=>$classFile)
    	{
    		require_once($classFile);
    		self::_baseClass[$class] = new $class;
    	}

    }
    public static function dispatcher()
    {

    }
}



?>