<?php
namespace PMVC\PlugIn\routing;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\routing';

\PMVC\initPlugIn(array(
    'url'=>null,
    'http'=>null
));

class routing extends \PMVC\PlugIn\http\http
{
    public function onMapRequest()
    {
        $uri = \PMVC\plug('url')->getPathInfo();
        if (empty($uri)) {
            return;
        }
        $uris = explode('/', $uri);
        $controller = \PMVC\getC();
        $request = $controller->getRequest();
        for ($i=0, $j=count($uris);$i<$j-1;$i++) {
            $request[$i]=urldecode($uris[$i+1]);
        }
        if (!empty($request[0])) {
            $controller->setApp($request[0]);
        }
        if (!empty($request[1])) {
            $controller->setAppAction($request[1]);
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

    public function init()
    {
        \PMVC\call_plugin(
            'dispatcher',
            'attach',
            array(
                $this,
                \PMVC\Event\MAP_REQUEST
            )
        );
    }
}
