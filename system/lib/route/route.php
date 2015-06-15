<?php
namespace System\Lib\Route;
use System\Lib\Request;

class route{
	public  $appName;
	public  $controller;
	public  $action;
	public  $params;

	private $_request;
	private $_type;
	pirvate $_url_arr;
	private $_callbacks = array();

	public function __construct()
	{
		 $this->_url_arr = parse_url($_SERVER['REQUEST_URI']);

	}
	public function init($type=2)
	{
		$this->setUrlType($type);
 
		if( $this->_type == 1)
		{
			/*
			| 格式一:
			| http://www.lamb.com/index.php/app=welcome&controller=index&action=index&first=1&second=2&third=3
			*/ 
			if(!empty($this->_urlArr['query']))
			{
				$queryArr = explode('&', $this->_urlArr['query']);
				$tmpArr = array();
				foreach($queryArr as $item)
				{
					list($key,$vale)=explode('=', $item);
					$tmpArr[$key] = $value;
					$key="",$value="";
				}
				if(isset($tmpArr['app']))
				{
					$this->appName=$tmp_arr['app'];
					unset($tmpArr['app']);
				}
				if(isset($tmpArr['controller']))
				{
					$this->controller=$tmpArr['controller'];
					unset($tmpArr['controller']);
				}
				if(isset($tmpArr['action']))
				{
					$this->action=$tmpArr['action'];
					unset($tmpArr['action']);
				}
                if(count($tmpArr) > 0){ 
                    $this->params = $tmpArr;
                } 
			}else{
                $this->appName = $this->controller = $this->action = $this->params = "";
			}
		}else if($this->_type == 2)
		{
			/*
			| 格式二:
			| http://www.lamb.com/index.php/welcome/index/index/first/1/second/2/third/3
			*/
			if(!empty($this->_urlArr['path']))
			{
				$pathArr = explode('/', $this->_urlArr['path']);
				$tmpArr = array();
				if( ( $pathCount = count($pathArr) > 1 ) )
				{
					$this->appName    = $pathArr[0];
					unset($pathArr[0]);
					$this->controller = $pathArr[1];
					unset($pathArr[1]);
					$this->action     = $pathArr[2];
					unset($pathArr[2]);

	                if($paramCount=count($pathArr) > 0 && $paramCount%2 == 0){
	                	$i=1;
	                	foreach($pathArr as $val)
	                	{
	                		if($i % 2 == 0)
	                		{
	                			$value = $val;
	                			$param=array($key,$value);
	                			$this->params=array_merge($this->params,$param);
	                			unset($key),unset($value),unset($param);
	                		}else{
	                			$key   = $val;
	                		}
	                		$i=$i+1;
	                	}
	                } 

				}else{
					$this->appName = $this->controller = $this->action = $this->params = "";
				}
			}else{
                $this->appName = $this->controller = $this->action = $this->params = "";
			}
		}
	}
	public function getRequest()
	{
		return $this->_request;
	}
	public function setUrlType($type)
	{
	     if($type > 0 && $type <3){
	        $this->_type = $type;
	     }else{
            die("URL模式不对");
	     }

	}
	public function before($filters)
	{
        return $this->addFilters('before', $filters);
	}
	public function after($filters)
	{
        return $this->addFilters('after', $filters);
	}
	protected function addFilters($type, $filters)
	{
		$this->_callbacks[$type] = $filters;
	}

}

?>