<?php
namespace test\Peast\Syntax\ES2018;

class ES2018Test extends \test\Peast\Syntax\ES2017\ES2017Test
{
    protected $parser = "ES2018";
    
    protected function getTestVersions()
    {
        return array("ES2015", "ES2016", "ES2017", "ES2018");
    }
}