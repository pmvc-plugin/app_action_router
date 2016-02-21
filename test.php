<?php
PMVC\Load::mvc();
PMVC\addPlugInFolder('../');

class RoutingTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'app_action_router';
    function testPlugin()
    {
        $mvc = new \PMVC\ActionController();
        ob_start();
        print_r(PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

}
