<?php
PMVC\Load::plug();
PMVC\addPlugInFolders(['../']);

class RoutingTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'app_action_router';
    function testPlugin()
    {
        ob_start();
        print_r(PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testOnMapRequest()
    {
        $p = \PMVC\plug($this->_plug);
        $url = \PMVC\plug('url', [
            'REQUEST_URI'=>'/fake/hello',
            'SCRIPT_NAME'=>'/fake/'
        ]);
        $p->onMapRequest();
        $r = \PMVC\plug('controller')->getRequest();
        $this->assertEquals(['hello'],\PMVC\get($r));
    }
}
