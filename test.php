<?php
PMVC\Load::plug();
PMVC\addPlugInFolders(['../']);

class RoutingTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'app_action_router';

    function setup()
    {
        \PMVC\unplug('url');
        \PMVC\unplug('http');
        \PMVC\unplug($this->_plug);
    }

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
        $url = \PMVC\plug('url', [
            'REQUEST_URI'=>'/fake/index.php/hello',
            'SCRIPT_NAME'=>'/fake/index.php'
        ]);
        \PMVC\plug('http');
        $p = \PMVC\plug($this->_plug);
        $p->onMapRequest();
        $r = \PMVC\plug('controller')->getRequest();
        $this->assertEquals(['hello'],\PMVC\get($r));
        $this->assertEquals('hello',\PMVC\plug('controller')->getApp());
    }
}
