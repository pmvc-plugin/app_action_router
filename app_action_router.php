<?php
namespace PMVC\PlugIn\app_action_router;

use PMVC\PlugIn\http\http;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\app_action_router';

\PMVC\initPlugIn([
    'url'=>null,
    'http'=>null
]);

const SEO = '__seo__';

/**
 * @parameters bool appOnly 
 * @parameters bool seo
 */
class app_action_router 
    extends http
{
    public function onMapRequest()
    {
        $controller = \PMVC\plug('controller');
        $request = $controller->getRequest();

        // detect seo
        $first = $request[0];
        if ($this['seo'] && ' ' === substr($first, -1)) {
            $app = $request[1];
            $action = $request[2];
            if (!isset($request[SEO])) {
                $request[SEO] = substr($first, 0, -1);
            }
        } else {
            $app = $request[0];
            $action = $request[1];
        }

        if (empty($app)) {
            return;
        } else {
            $controller->setApp($app);
        }

        if (!empty($action) &&
            empty($this['appOnly'])
        ) {
            $controller->setAppAction($action);
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
