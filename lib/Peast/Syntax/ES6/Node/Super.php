<?php
namespace Peast\Syntax\ES6\Node;

class Super extends Node
{
    public function compile()
    {
        return "super";
    }
}