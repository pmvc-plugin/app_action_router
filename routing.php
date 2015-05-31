<?php
${_INIT_CONFIG}[_CLASS] = '_PMVC_ROUTING';

PMVC\initPlugIn(array(
    'dispatcher'=>null,
    'url'=>null
));

class _PMVC_ROUTING extends PMVC\PLUGIN {

    function onMapRequest(){        
        $uri = PMVC\plug('url')->getPathInfo();
        if(strlen($uri)<=1){
            return;
        }
        $uri = explode('/',$uri);
	$controller = PMVC\getC();
        $request = $controller->getRequest(); 
        for($i=0,$j=count($uri);$i<$j-1;$i++){
            $request->set($i, urldecode($uri[$i+1]));
        }
        $controller->store(array(
             _RUN_APP=>$request->get(0),
             _RUN_ACTION=>$request->get(1)
        ));
    }

    function actionToUrl($action,$url=null){
        if(is_null($url)){
            $url = getenv('SCRIPT_NAME');
        }
        if(strlen($action)){
            return _PMVC::lastSlash($url).$action;
        }else{
            return $url;
        }
    }

    function initActionForm($inti,$actionForm){
        $uri = $this->get('uri');
        for($i=1,$j=count($uri);$i<$j;$i++){
            $actionForm->put($init[$i-1], $uri[$i]);
        }
    }

    function init(){
        PMVC\plug('dispatcher')->attach($this,'MapRequest');
    } 

    /**
     * execute other php
     */
    function go($path){
        //header('HTTP/1.1 301 Moved Permanently'); //can't use, will effect post
        header('Location:'.$path);
        exit();
    }

    /**
    * join query
    */
    function joinQuery($path,$attr){
        $add_path = array();
        if(!is_array($attr)){
            return $path;
        }
        foreach($attr as $k=>$v){
            $add_path[]=htmlentities(urlencode($k)).'='.htmlentities(urlencode($v));
        }
        $path .= ((false===strpos($path,'?'))?'?':'&'). join('&',$add_path);
        return $path;
    }

}
    
?>
