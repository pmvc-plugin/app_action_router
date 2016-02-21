<?php
PMVC\Load::mvc();
PMVC\addPlugInFolder('../');

class RoutingTest extends PHPUnit_Framework_TestCase
{
    function testPlugin()
    {
        $mvc = new \PMVC\ActionController();
        ob_start();
        $plug = 'routing';
        print_r(PMVC\plug($plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($plug,$output);
    }

}
