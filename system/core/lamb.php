<?php
use System\Lib\Config;
final class Application{
	public static $_baseClass=null;
	private static $_finishCallbacks=array();
	private static $_shutdownCallbacks=array();
    public static function init()
    {
    	self::autoload();
    }
    public static function run()
    {
    	self::init();
    	$route = self::$_baseClass['route'];
    	$route->setUrlType(config::get("common.route.type")); 
    	$request =  $route->_request;
        $response =  self::dispatcher($request);
        $response->send();
        self::terminate($request, $response);
    }
    public static function register($serverName,$filePath=false)
    {
    	if (is_string($serverName))
		{
			self::_baseClass[$serverName] = self::resolveServer($serverName,$filePath);
		}else{
		    if(is_object($serverName))
		    {
		    	self::_baseClass[get_class($serverName)] = $serverName;
		    }
		}

    }
    public static function resolveServer($serverName,$filePath)
    {
    	require_once($filePath);
    	if(class_exists($serverName))
    	{
    		return new $serverName;
    	}
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
    public static function dispatcher(&$request)
    {
    	$appName = '';
    	$controller = '';
    	$action = '';
    	$model = '';
    	$params = '';
    	$response = null;

        $appName      = !empty($route->getAppName) ? $route->getAppName : '';
        $controller   = !empty($route->controller) ? $route->controller : config::get('common.route.defaultController'); 
        $action       = !empty($route->action) ? $route->action : config::get('common.route.defaultAction');
        $params       = !empty($route->params) ? $route->params : '';
        if(!empty($controller))
        {
            $model = $controller;
            if(!empty($appName))
            {
                $controller_file = APPLICATION . '/controller/'.$app.'/'.$controller.'Controller.php';  
                $model_file      = APPLICATION . '/model/'.$app.'/'.$model.'Model.php'; 
            }else{
                $controller_file = APPLICATION . '/controller/'.$controller.'Controller.php';  
                $model_file      = APPLICATION . '/model/'.$model.'Model.php'; 
            }

        }
        try{ 
            if (file_exists($model_file)) {  
                require_once($model_file);  
            }
            if(file_exists($controller_file))
            {
	            require_once($controller_file);
	        	$controllerClass = $controller.'Controller';
	        	$controllerInstance = new $controllerClass;
	        	if(!empty($action))
	        	{
	        		if(method_exists($controllerClass, $action))
	        		{
                        $response = $controllerInstance->$action($params); 
                        return $response;
	        		}else{
                        throw Exception("controller's method is not exist!");
	        		}
	        	}else{
	        		throw Exception("controller's method is not exist!");
	        	}

            }else{
            	throw Exception("controller file is not exist!");
            } 
        }catch(Exception $e)
        {
        	die($e->getMessage());
        }
    }
    private static function terminate($request,$response)
    {
    	self::finish();
    	self::shutdown();
    }
    public static function before($callback)
    {
        return self::$_baseClass['route']->before($callback);
    }
    public static function after($callback)
    {
    	return self::$_baseClass['route']->after($callback);
    }
    public static function finish($callback=null,$request=null,$response=null)
    {
    	if(is_null($callback))
    	{
            self::fireFinish(self::_finishCallbacks,$request,$response);
    	}else{
    	    self::_finishCallbacks[] = $callback;
    	}
    }
    public static function shutdown($callback)
    {
      	if(is_null($callback))
    	{
            self::fireShutdown(self::_finishCallbacks);
    	}else{
    	    self::_finishCallbacks[] = $callback;
    	}  	
    }
    public static function fireFinish($callbacks,$request,$response)
    {
    	foreach ($callbacks as $callback)
		{
			call_user_func($callback, $request, $response);
		}
    }
    public static function fireShutdown($callbacks)
    {
    	foreach ($callbacks as $callback)
		{
			call_user_func($callback, self);
		}
    }
}



?>