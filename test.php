<?php
PMVC\Load::plug();
PMVC\setPlugInFolder('../');

class RoutingTest extends PHPUnit_Framework_TestCase
{
    function testRouting()
    {
        var_dump(PMVC\plug('routing'));
    }


}
