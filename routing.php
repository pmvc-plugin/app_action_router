<?php
namespace PMVC\PlugIn\routing;

${_INIT_CONFIG}[_CLASS] = 'PMVC\PlugIn\routing\routing';

\PMVC\initPlugIn(array(
    'dispatcher'=>null,
    'url'=>null
));

class routing extends \PMVC\PlugIn
{
    private $uri;
    public function onMapRequest()
    {
        $this->uri = \PMVC\plug('url')->getPathInfo();
        if (empty($this->uri)) {
            return;
        }
        $uris = explode('/', $this->uri);
        $controller = \PMVC\getC();
        $request = $controller->getRequest();
        for ($i=0, $j=count($uris);$i<$j-1;$i++) {
            $request[$i]=urldecode($uris[$i+1]);
        }
        if (!empty($request[0])) {
            $controller->store(_RUN_APP, $request[0]);
        }
        if (!empty($request[1])) {
            $controller->store(_RUN_ACTION, $request[1]);
        }
    }

    public function actionToUrl($action, $url=null)
    {
        if (is_null($url)) {
            $url = \PMVC\plug('url')['SCRIPT_NAME'];
        }
        if (strlen($action)) {
            return \PMVC\lastSlash($url).$action;
        } else {
            return $url;
        }
    }

    public function initActionForm($inti, $actionForm)
    {
        $uri = $this['uri'];
        for ($i=1, $j=count($uri);$i<$j;$i++) {
            $actionForm->put($init[$i-1], $uri[$i]);
        }
    }

    public function init()
    {
        \PMVC\plug('dispatcher')->attach($this, 'MapRequest');
    }

    /**
     * execute other php
     */
    public function go($path)
    {
        header('Location:'.$path);
        exit();
    }

    /**
    * join query
    */
    public function joinQuery($path, $attr)
    {
        $add_path = array();
        if (!is_array($attr)) {
            return $path;
        }
        foreach ($attr as $k=>$v) {
            $add_path[]=htmlentities(urlencode($k)).'='.htmlentities(urlencode($v));
        }
        $path .= ((false===strpos($path, '?'))?'?':'&'). join('&', $add_path);
        return $path;
    }
}
