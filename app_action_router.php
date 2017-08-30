<?php
namespace PMVC\PlugIn\app_action_router;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\app_action_router';

\PMVC\initPlugIn(array(
    'url'=>null,
    'http'=>null
));

class app_action_router 
    extends \PMVC\PlugIn\http\http
    implements \PMVC\RouterInterface
{
    public function onMapRequest()
    {
        $controller = \PMVC\plug('controller');
        $request = $controller->getRequest();
        if (empty($request[0])) {
            return;
        }
        if (!empty($request[0])) {
            $controller->setApp($request[0]);
        }
        if (!empty($request[1])) {
            $controller->setAppAction($request[1]);
        }
    }

    public function init()
    {
        \PMVC\callPlugin(
            'dispatcher',
            'attach',
            array(
                $this,
                \PMVC\Event\MAP_REQUEST
            )
        );
    }
}
